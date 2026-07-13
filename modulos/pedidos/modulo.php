<?php

return [
    'id' => 'pedidos',
    'nombre' => 'Pedidos',
    'descripcion' => 'Recibe y gestiona pedidos de tus clientes por WhatsApp',
    'icono' => 'shopping-bag',
    'menu_panel' => [
        ['url' => '/panel/pedidos', 'label' => 'Pedidos', 'icono' => 'shopping-bag'],
    ],
    'planes' => ['gratis', 'basico', 'pro'],
];
