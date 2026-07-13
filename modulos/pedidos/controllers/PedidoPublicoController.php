<?php

require_once BASE_PATH . '/modulos/pedidos/models/Pedido.php';
require_once BASE_PATH . '/modulos/catalogo/models/Producto.php';

class PedidoPublicoController {

    public function crear($slug) {
        $negocio = (new Negocio())->porSlug($slug);
        if (!$negocio) {
            http_response_code(404);
            echo json_encode(['error' => 'Negocio no encontrado']);
            return;
        }

        if (!tieneModulo($negocio['id'], 'pedidos')) {
            http_response_code(404);
            echo json_encode(['error' => 'Pedidos no disponible']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos invalidos']);
            return;
        }

        $errores = validar($input, [
            'cliente_nombre' => 'required|min:2|max:100',
            'cliente_telefono' => 'required|min:8|max:20',
        ]);
        if (!empty($errores)) {
            http_response_code(400);
            echo json_encode(['error' => array_values($errores)[0]]);
            return;
        }

        $nombre = trim($input['cliente_nombre']);
        $telefono = trim($input['cliente_telefono']);
        $direccion = trim($input['cliente_direccion'] ?? '');
        $nota = trim($input['nota'] ?? '');
        $metodo = $input['metodo_entrega'] ?? 'delivery';
        $items = $input['items'] ?? [];

        if (empty($items)) {
            http_response_code(400);
            echo json_encode(['error' => 'Al menos un producto es obligatorio']);
            return;
        }

        $productoModel = new Producto();
        $total = 0;
        $itemsValidados = [];

        foreach ($items as $item) {
            $producto = $productoModel->porId($item['id'], $negocio['id']);
            if (!$producto || !$producto['disponible']) continue;

            $cantidad = max(1, intval($item['cantidad'] ?? 1));
            $subtotal = $producto['precio'] * $cantidad;
            $total += $subtotal;

            $itemsValidados[] = [
                'producto_id' => $producto['id'],
                'nombre_producto' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
            ];
        }

        if (empty($itemsValidados)) {
            http_response_code(400);
            echo json_encode(['error' => 'No hay productos validos en el pedido']);
            return;
        }

        $db = getDB();
        $db->beginTransaction();

        try {
            $pedidoModel = new Pedido();
            $pedidoId = $pedidoModel->crear([
                'negocio_id' => $negocio['id'],
                'cliente_nombre' => $nombre,
                'cliente_telefono' => $telefono,
                'cliente_direccion' => $direccion,
                'nota' => $nota,
                'total' => $total,
                'metodo_entrega' => $metodo,
            ]);

            foreach ($itemsValidados as $item) {
                $pedidoModel->agregarItem($pedidoId, $item);
            }

            $db->commit();

            $pedido = $pedidoModel->porId($pedidoId, $negocio['id']);
            $mensaje = $this->generarMensajeWhatsApp($negocio, $pedido['numero'], $nombre, $telefono, $direccion, $nota, $metodo, $itemsValidados, $total);
            $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $negocio['telefono']) . '?text=' . urlencode($mensaje);

            header('Content-Type: application/json');
            echo json_encode(['url' => $waUrl]);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el pedido']);
        }
    }

    private function generarMensajeWhatsApp($negocio, $numero, $nombre, $telefono, $direccion, $nota, $metodo, $items, $total) {
        $moneda = $negocio['moneda'] ?? 'C$';
        $lineas = [];
        $lineas[] = "--- NUEVO PEDIDO #{$numero} ---";
        $lineas[] = "";
        $lineas[] = "Cliente: {$nombre}";
        $lineas[] = "Telefono: {$telefono}";
        if ($direccion) $lineas[] = "Direccion: {$direccion}";
        $lineas[] = "Entrega: " . ($metodo === 'delivery' ? 'Delivery' : 'Recoger en tienda');
        $lineas[] = "";
        $lineas[] = "PRODUCTOS:";

        foreach ($items as $item) {
            $sub = number_format($item['precio'] * $item['cantidad'], 2);
            $lineas[] = "- {$item['nombre_producto']} x{$item['cantidad']} = {$moneda} {$sub}";
        }

        $lineas[] = "";
        $lineas[] = "TOTAL: {$moneda} " . number_format($total, 2);

        if ($nota) {
            $lineas[] = "";
            $lineas[] = "Nota: {$nota}";
        }

        return implode("\n", $lineas);
    }
}
