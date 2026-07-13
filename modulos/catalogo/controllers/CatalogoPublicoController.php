<?php

require_once BASE_PATH . '/modulos/catalogo/models/Producto.php';
require_once BASE_PATH . '/modulos/catalogo/models/Categoria.php';
require_once BASE_PATH . '/modulos/catalogo/models/ProductoImagen.php';

class CatalogoPublicoController {

    public function show($slug) {
        $negocio = (new Negocio())->porSlug($slug);
        if (!$negocio) {
            http_response_code(404);
            require BASE_PATH . '/views/landing/404.php';
            return;
        }

        $productos = (new Producto())->publicosPorNegocio($negocio['id']);
        $categorias = (new Categoria())->porNegocio($negocio['id']);

        $porCategoria = [];
        $sinCategoria = [];
        foreach ($productos as $p) {
            if ($p['categoria_nombre']) {
                $porCategoria[$p['categoria_nombre']][] = $p;
            } else {
                $sinCategoria[] = $p;
            }
        }

        $tienePedidos = tieneModulo($negocio['id'], 'pedidos');

        renderPublico('catalogo', 'publico/catalogo', [
            'negocio' => $negocio,
            'porCategoria' => $porCategoria,
            'sinCategoria' => $sinCategoria,
            'totalProductos' => count($productos),
            'tienePedidos' => $tienePedidos,
        ]);
    }

    public function detalle($slug, $id) {
        $negocio = (new Negocio())->porSlug($slug);
        if (!$negocio) {
            http_response_code(404);
            require BASE_PATH . '/views/landing/404.php';
            return;
        }

        $productoModel = new Producto();
        $producto = $productoModel->porIdPublico((int) $id, $negocio['id']);
        if (!$producto) {
            http_response_code(404);
            require BASE_PATH . '/views/landing/404.php';
            return;
        }

        $relacionados = $productoModel->relacionados(
            $negocio['id'],
            $producto['categoria_id'],
            $producto['id']
        );

        $imagenes = (new ProductoImagen())->porProducto($producto['id']);

        $tienePedidos = tieneModulo($negocio['id'], 'pedidos');

        renderPublico('catalogo', 'publico/producto-detalle', [
            'negocio' => $negocio,
            'producto' => $producto,
            'imagenes' => $imagenes,
            'relacionados' => $relacionados,
            'tienePedidos' => $tienePedidos,
        ]);
    }
}
