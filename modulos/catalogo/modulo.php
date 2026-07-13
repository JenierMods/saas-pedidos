<?php

return [
    'id' => 'catalogo',
    'nombre' => 'Catalogo web',
    'descripcion' => 'Muestra tus productos en una pagina que puedes compartir',
    'icono' => 'box',
    'menu_panel' => [
        ['url' => '/panel/productos', 'label' => 'Productos', 'icono' => 'box'],
        ['url' => '/panel/categorias', 'label' => 'Categorias', 'icono' => 'list'],
    ],
    'planes' => ['gratis', 'basico', 'pro'],
];
