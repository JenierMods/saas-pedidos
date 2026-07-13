<?php

get('/panel/productos', ['ProductoController', 'index']);
get('/panel/productos/crear', ['ProductoController', 'crear']);
post('/panel/productos/guardar', ['ProductoController', 'guardar']);
get('/panel/productos/editar/{id}', ['ProductoController', 'editar']);
post('/panel/productos/actualizar/{id}', ['ProductoController', 'actualizar']);
post('/panel/productos/eliminar/{id}', ['ProductoController', 'eliminar']);
post('/panel/productos/disponibilidad/{id}', ['ProductoController', 'toggleDisponibilidad']);

get('/panel/categorias', ['CategoriaController', 'index']);
post('/panel/categorias/guardar', ['CategoriaController', 'guardar']);
post('/panel/categorias/eliminar/{id}', ['CategoriaController', 'eliminar']);

get('/tienda/{slug}', ['CatalogoPublicoController', 'show']);
get('/tienda/{slug}/producto/{id}', ['CatalogoPublicoController', 'detalle']);
