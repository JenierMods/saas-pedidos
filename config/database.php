<?php

function getDB() {
    static $db = null;
    if ($db === null) {
        $host = env('DB_HOST', 'localhost');
        $name = env('DB_NAME', '');
        $user = env('DB_USER', '');
        $pass = env('DB_PASS', '');
        $db = new PDO(
            "mysql:host=$host;dbname=$name;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
    return $db;
}
