<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

foreach (glob(BASE_PATH . '/helpers/*.php') as $helper) {
    require_once $helper;
}

foreach (glob(BASE_PATH . '/models/*.php') as $model) {
    require_once $model;
}

$routes = ['GET' => [], 'POST' => []];

function get($path, $handler) {
    global $routes;
    $routes['GET'][$path] = $handler;
}

function post($path, $handler) {
    global $routes;
    $routes['POST'][$path] = $handler;
}

require_once BASE_PATH . '/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

$rutasApiPublicas = [
    '#^/tienda/[^/]+/pedido$#',
];

$esApiPublica = false;
foreach ($rutasApiPublicas as $patron) {
    if (preg_match($patron, $uri)) {
        $esApiPublica = true;
        break;
    }
}

if ($method === 'POST' && !$esApiPublica) {
    verificarCsrf();
}

$matched = false;

foreach ($routes[$method] ?? [] as $pattern => $handler) {
    $regex = preg_replace('#\{([a-zA-Z_]+)\}#', '([^/]+)', $pattern);
    $regex = '#^' . $regex . '$#';

    if (preg_match($regex, $uri, $matches)) {
        array_shift($matches);

        $moduloDir = null;
        foreach ($routes[$method] as $p => $h) {
            if ($p === $pattern) break;
        }

        $controllerName = $handler[0];
        $methodName = $handler[1];

        $moduloPaths = glob(BASE_PATH . '/modulos/*/controllers/' . $controllerName . '.php');
        if ($moduloPaths) {
            require_once $moduloPaths[0];
        } elseif (file_exists(BASE_PATH . '/controllers/' . $controllerName . '.php')) {
            require_once BASE_PATH . '/controllers/' . $controllerName . '.php';
        }

        $controller = new $controllerName();
        call_user_func_array([$controller, $methodName], $matches);
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    if (file_exists(BASE_PATH . '/views/landing/404.php')) {
        require BASE_PATH . '/views/landing/404.php';
    } else {
        echo 'Pagina no encontrada';
    }
}
