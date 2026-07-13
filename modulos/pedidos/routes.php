<?php

get('/panel/pedidos', ['PedidoController', 'index']);
get('/panel/pedidos/{id}', ['PedidoController', 'detalle']);
post('/panel/pedidos/{id}/estado', ['PedidoController', 'cambiarEstado']);

post('/tienda/{slug}/pedido', ['PedidoPublicoController', 'crear']);
