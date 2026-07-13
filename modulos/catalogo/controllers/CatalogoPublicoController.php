<?php

require_once BASE_PATH . '/modulos/catalogo/models/Producto.php';
require_once BASE_PATH . '/modulos/catalogo/models/Categoria.php';

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
}
