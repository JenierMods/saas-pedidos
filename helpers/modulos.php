<?php

function modulosActivos($negocio_id) {
    static $cache = [];
    if (isset($cache[$negocio_id])) return $cache[$negocio_id];

    $stmt = getDB()->prepare(
        "SELECT modulo FROM negocio_modulos WHERE negocio_id = ? AND activo = 1"
    );
    $stmt->execute([$negocio_id]);
    $cache[$negocio_id] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $cache[$negocio_id];
}

function tieneModulo($negocio_id, $modulo) {
    return in_array($modulo, modulosActivos($negocio_id));
}

function menuModulos($negocio_id) {
    $menu = [];
    $activos = modulosActivos($negocio_id);
    foreach ($activos as $modulo) {
        $configFile = BASE_PATH . "/modulos/$modulo/modulo.php";
        if (file_exists($configFile)) {
            $config = require $configFile;
            if (isset($config['menu_panel'])) {
                $menu = array_merge($menu, $config['menu_panel']);
            }
        }
    }
    return $menu;
}

function cargarRutasModulos() {
    $dir = BASE_PATH . '/modulos/';
    foreach (glob($dir . '*/routes.php') as $archivo) {
        require $archivo;
    }
}

function modulosDisponibles() {
    $modulos = [];
    foreach (glob(BASE_PATH . '/modulos/*/modulo.php') as $archivo) {
        $config = require $archivo;
        $modulos[$config['id']] = $config;
    }
    return $modulos;
}
