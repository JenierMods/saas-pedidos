<?php

get('/', ['LandingController', 'index']);
get('/login', ['AuthController', 'loginForm']);
post('/login', ['AuthController', 'login']);
get('/registro', ['AuthController', 'registroForm']);
post('/registro', ['AuthController', 'registro']);
post('/logout', ['AuthController', 'logout']);

get('/panel', ['DashboardController', 'index']);
get('/panel/config', ['ConfigController', 'index']);
post('/panel/config', ['ConfigController', 'guardar']);

cargarRutasModulos();
