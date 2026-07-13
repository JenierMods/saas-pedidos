<?php

function csrf() {
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrfField() {
    return '<input type="hidden" name="_csrf" value="' . csrf() . '">';
}

function verificarCsrf() {
    $token = $_POST['_csrf']
        ?? $_SERVER['HTTP_X_CSRF_TOKEN']
        ?? '';
    if (!hash_equals(csrf(), $token)) {
        http_response_code(403);
        $esJson = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
        if ($esJson) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Token de seguridad invalido']);
        } else {
            echo 'Token de seguridad invalido. Recarga la pagina.';
        }
        exit;
    }
}
