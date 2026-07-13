<?php

function sanitize($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function validar($data, $reglas) {
    $errores = [];
    foreach ($reglas as $campo => $regla) {
        $valor = trim($data[$campo] ?? '');
        $partes = explode('|', $regla);

        foreach ($partes as $r) {
            if ($r === 'required' && $valor === '') {
                $errores[$campo] = ucfirst($campo) . ' es obligatorio';
                break;
            }
            if ($r === 'email' && $valor !== '' && !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                $errores[$campo] = 'Email no valido';
                break;
            }
            if (str_starts_with($r, 'min:')) {
                $min = (int) substr($r, 4);
                if (mb_strlen($valor) < $min) {
                    $errores[$campo] = ucfirst($campo) . " debe tener al menos $min caracteres";
                    break;
                }
            }
            if (str_starts_with($r, 'max:')) {
                $max = (int) substr($r, 4);
                if (mb_strlen($valor) > $max) {
                    $errores[$campo] = ucfirst($campo) . " no debe exceder $max caracteres";
                    break;
                }
            }
            if ($r === 'numeric' && $valor !== '' && !is_numeric($valor)) {
                $errores[$campo] = ucfirst($campo) . ' debe ser un numero';
                break;
            }
        }
    }
    return $errores;
}

function slug($texto) {
    $texto = mb_strtolower($texto);
    $texto = preg_replace('/[\x{00e1}\x{00e0}\x{00e4}]/u', 'a', $texto);
    $texto = preg_replace('/[\x{00e9}\x{00e8}\x{00eb}]/u', 'e', $texto);
    $texto = preg_replace('/[\x{00ed}\x{00ec}\x{00ef}]/u', 'i', $texto);
    $texto = preg_replace('/[\x{00f3}\x{00f2}\x{00f6}]/u', 'o', $texto);
    $texto = preg_replace('/[\x{00fa}\x{00f9}\x{00fc}]/u', 'u', $texto);
    $texto = preg_replace('/\x{00f1}/u', 'n', $texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}
