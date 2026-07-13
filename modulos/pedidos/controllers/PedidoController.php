<?php

require_once BASE_PATH . '/modulos/pedidos/models/Pedido.php';

class PedidoController {

    public function index() {
        requireLogin();
        $negocio_id = negocioId();
        $estado = $_GET['estado'] ?? null;
        $page = max(1, intval($_GET['page'] ?? 1));

        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->porNegocio($negocio_id, $estado, $page);
        $total = $pedidoModel->contar($negocio_id, $estado);
        $totalPages = ceil($total / 20);

        $conteos = [
            'todos' => $pedidoModel->contar($negocio_id),
            'nuevo' => $pedidoModel->contar($negocio_id, 'nuevo'),
            'preparando' => $pedidoModel->contar($negocio_id, 'preparando'),
            'listo' => $pedidoModel->contar($negocio_id, 'listo'),
            'entregado' => $pedidoModel->contar($negocio_id, 'entregado'),
            'cancelado' => $pedidoModel->contar($negocio_id, 'cancelado'),
        ];

        renderModulo('pedidos', 'panel/pedidos', [
            'pedidos' => $pedidos,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'estado' => $estado,
            'conteos' => $conteos,
            'user' => currentUser(),
        ]);
    }

    public function detalle($id) {
        requireLogin();
        $negocio_id = negocioId();
        $pedidoModel = new Pedido();

        $pedido = $pedidoModel->porId($id, $negocio_id);
        if (!$pedido) redirect('/panel/pedidos');

        $items = $pedidoModel->items($id);

        renderModulo('pedidos', 'panel/pedido-detalle', [
            'pedido' => $pedido,
            'items' => $items,
            'user' => currentUser(),
        ]);
    }

    public function cambiarEstado($id) {
        requireLogin();
        $estado = $_POST['estado'] ?? '';
        (new Pedido())->cambiarEstado($id, negocioId(), $estado);
        setFlash('exito', 'Estado actualizado');
        redirect('/panel/pedidos/' . $id);
    }
}
