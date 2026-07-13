<?php

function redirect($url) {
    header("Location: $url");
    exit;
}

function back() {
    redirect($_SERVER['HTTP_REFERER'] ?? '/panel');
}

function render($view, $data = [], $layout = 'panel') {
    extract($data);
    $contentFile = BASE_PATH . "/views/$view.php";
    if (!file_exists($contentFile)) {
        http_response_code(404);
        die('Vista no encontrada');
    }
    ob_start();
    require $contentFile;
    $content = ob_get_clean();
    require BASE_PATH . "/views/layouts/$layout.php";
}

function renderModulo($modulo, $view, $data = [], $layout = 'panel') {
    extract($data);
    $contentFile = BASE_PATH . "/modulos/$modulo/views/$view.php";
    if (!file_exists($contentFile)) {
        http_response_code(404);
        die('Vista no encontrada');
    }
    ob_start();
    require $contentFile;
    $content = ob_get_clean();
    require BASE_PATH . "/views/layouts/$layout.php";
}

function renderPublico($modulo, $view, $data = [], $layout = 'tienda') {
    extract($data);
    $contentFile = BASE_PATH . "/modulos/$modulo/views/$view.php";
    if (!file_exists($contentFile)) {
        http_response_code(404);
        die('Vista no encontrada');
    }
    ob_start();
    require $contentFile;
    $content = ob_get_clean();
    require BASE_PATH . "/views/layouts/$layout.php";
}

function setFlash($tipo, $mensaje) {
    $_SESSION['_flash'] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}

function getFlash() {
    $flash = $_SESSION['_flash'] ?? null;
    unset($_SESSION['_flash']);
    return $flash;
}

function url($path = '') {
    return APP_URL . $path;
}
