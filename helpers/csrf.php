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
    $token = $_POST['_csrf'] ?? '';
    if (!hash_equals(csrf(), $token)) {
        http_response_code(403);
        die('Token de seguridad invalido. Recarga la pagina.');
    }
}
