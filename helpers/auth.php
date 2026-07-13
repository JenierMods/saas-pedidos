<?php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function currentUser() {
    if (!isLoggedIn()) return null;
    static $user = null;
    if ($user === null) {
        $stmt = getDB()->prepare("
            SELECT u.*, n.nombre as negocio_nombre, n.slug, n.plan,
                   n.telefono as negocio_telefono, n.moneda, n.logo as negocio_logo
            FROM usuarios u
            JOIN negocios n ON u.negocio_id = n.id
            WHERE u.id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
    return $user;
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('/login');
    }
}

function negocioId() {
    return $_SESSION['negocio_id'] ?? 0;
}
