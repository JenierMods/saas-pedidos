<?php

function env($key, $default = null) {
    static $vars = null;
    if ($vars === null) {
        $envFile = __DIR__ . '/../.env';
        if (!file_exists($envFile)) return $default;
        $vars = [];
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $vars[trim($parts[0])] = trim($parts[1]);
            }
        }
    }
    return $vars[$key] ?? $default;
}

define('APP_NAME', env('APP_NAME', 'MiNegocioApp'));
define('APP_URL', env('APP_URL', 'http://localhost'));
define('APP_DEBUG', env('APP_DEBUG', 'false') === 'true');
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_MAX_SIZE', (int) env('UPLOAD_MAX_SIZE', 10485760));
define('UPLOAD_DIR', BASE_PATH . '/' . env('UPLOAD_DIR', 'uploads'));

date_default_timezone_set('America/Managua');

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}
