<?php

$ruta = $_GET['f'] ?? '';

if (!$ruta) {
    http_response_code(404);
    exit;
}

$uploadsDir = realpath(dirname(__DIR__) . '/uploads');
if ($uploadsDir === false) {
    http_response_code(404);
    exit;
}

$archivo = realpath($uploadsDir . '/' . $ruta);
if ($archivo === false || strpos($archivo, $uploadsDir . DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(403);
    exit;
}

$ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
$mimes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'webp' => 'image/webp',
];

if (!isset($mimes[$ext])) {
    http_response_code(403);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $archivo);
finfo_close($finfo);

if (!in_array($mime, $mimes)) {
    http_response_code(403);
    exit;
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($archivo));
header('Cache-Control: public, max-age=2592000');
readfile($archivo);
