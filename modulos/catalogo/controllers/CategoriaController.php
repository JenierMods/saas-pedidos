<?php

require_once BASE_PATH . '/modulos/catalogo/models/Categoria.php';

class CategoriaController {

    public function index() {
        requireLogin();
        $categorias = (new Categoria())->porNegocio(negocioId());
        renderModulo('catalogo', 'panel/categorias', [
            'categorias' => $categorias,
            'user' => currentUser(),
        ]);
    }

    public function guardar() {
        requireLogin();
        $nombre = trim($_POST['nombre'] ?? '');

        if (!$nombre) {
            setFlash('error', 'El nombre es obligatorio');
            redirect('/panel/categorias');
            return;
        }

        (new Categoria())->crear(negocioId(), $nombre);
        setFlash('exito', 'Categoria creada');
        redirect('/panel/categorias');
    }

    public function eliminar($id) {
        requireLogin();
        $categoriaModel = new Categoria();

        if ($categoriaModel->tieneProductos($id)) {
            setFlash('error', 'No puedes eliminar una categoria que tiene productos');
            redirect('/panel/categorias');
            return;
        }

        $categoriaModel->eliminar($id, negocioId());
        setFlash('exito', 'Categoria eliminada');
        redirect('/panel/categorias');
    }
}
