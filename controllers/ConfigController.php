<?php

class ConfigController {

    public function index() {
        requireLogin();
        $negocio = (new Negocio())->porId(negocioId());
        renderModulo('catalogo', 'panel/config', ['negocio' => $negocio]);
    }

    public function guardar() {
        requireLogin();
        $negocio_id = negocioId();
        $negocioModel = new Negocio();

        $errores = validar($_POST, [
            'nombre' => 'required|min:2|max:100',
            'telefono' => 'required|min:8|max:20',
        ]);

        if ($errores) {
            $negocio = $negocioModel->porId($negocio_id);
            render('panel/config', ['negocio' => $negocio, 'errores' => $errores]);
            return;
        }

        $data = [
            'nombre' => trim($_POST['nombre']),
            'telefono' => trim($_POST['telefono']),
            'moneda' => trim($_POST['moneda'] ?? 'C$'),
            'horario' => trim($_POST['horario'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
        ];

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $resultado = subirImagen('logo', 'logos');
            if (isset($resultado['error'])) {
                $negocio = $negocioModel->porId($negocio_id);
                render('panel/config', ['negocio' => $negocio, 'errores' => ['logo' => $resultado['error']]]);
                return;
            }
            $negocioActual = $negocioModel->porId($negocio_id);
            if ($negocioActual['logo']) borrarImagen($negocioActual['logo']);
            $data['logo'] = $resultado['ruta'];
        }

        $newSlug = slug($_POST['nombre']);
        if (!$negocioModel->slugExiste($newSlug, $negocio_id)) {
            $data['slug'] = $newSlug;
        }

        $negocioModel->actualizar($negocio_id, $data);
        setFlash('exito', 'Ajustes guardados');
        redirect('/panel/config');
    }
}
