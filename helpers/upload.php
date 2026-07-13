<?php

function subirImagen($campo, $carpeta = '') {
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$campo];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidas)) {
        return ['error' => 'Solo se permiten imagenes JPG, PNG o WEBP'];
    }

    if ($file['size'] > UPLOAD_MAX_SIZE) {
        return ['error' => 'La imagen no debe superar 5 MB'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $mimesPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime, $mimesPermitidos)) {
        return ['error' => 'El archivo no es una imagen valida'];
    }

    $destino = UPLOAD_DIR;
    if ($carpeta) {
        $destino .= '/' . $carpeta;
    }
    if (!is_dir($destino)) {
        mkdir($destino, 0755, true);
    }

    $nombre = bin2hex(random_bytes(16)) . '.' . $ext;
    $ruta = $destino . '/' . $nombre;

    if (!move_uploaded_file($file['tmp_name'], $ruta)) {
        return ['error' => 'Error al guardar la imagen'];
    }

    $rutaRelativa = ($carpeta ? "$carpeta/" : '') . $nombre;
    return ['ruta' => $rutaRelativa];
}

function borrarImagen($ruta) {
    if ($ruta) {
        $archivo = UPLOAD_DIR . '/' . $ruta;
        if (file_exists($archivo)) {
            unlink($archivo);
        }
    }
}
