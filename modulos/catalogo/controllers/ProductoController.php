<?php

require_once BASE_PATH . '/modulos/catalogo/models/Producto.php';
require_once BASE_PATH . '/modulos/catalogo/models/Categoria.php';

class ProductoController {

    public function index() {
        requireLogin();
        $negocio_id = negocioId();
        $page = max(1, intval($_GET['page'] ?? 1));
        $productoModel = new Producto();

        $productos = $productoModel->porNegocio($negocio_id, $page);
        $total = $productoModel->contar($negocio_id);
        $totalPages = ceil($total / 20);

        renderModulo('catalogo', 'panel/productos', [
            'productos' => $productos,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'user' => currentUser(),
        ]);
    }

    public function crear() {
        requireLogin();
        $categorias = (new Categoria())->porNegocio(negocioId());
        renderModulo('catalogo', 'panel/producto-form', [
            'categorias' => $categorias,
            'producto' => null,
            'user' => currentUser(),
        ]);
    }

    public function guardar() {
        requireLogin();
        $negocio_id = negocioId();

        $errores = validar($_POST, [
            'nombre' => 'required|min:2|max:150',
            'precio' => 'required|numeric',
        ]);

        if ($errores) {
            $categorias = (new Categoria())->porNegocio($negocio_id);
            renderModulo('catalogo', 'panel/producto-form', [
                'categorias' => $categorias,
                'producto' => null,
                'errores' => $errores,
                'old' => $_POST,
                'user' => currentUser(),
            ]);
            return;
        }

        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $resultado = subirImagen('imagen', 'productos');
            if (isset($resultado['error'])) {
                $categorias = (new Categoria())->porNegocio($negocio_id);
                renderModulo('catalogo', 'panel/producto-form', [
                    'categorias' => $categorias,
                    'producto' => null,
                    'errores' => ['imagen' => $resultado['error']],
                    'old' => $_POST,
                    'user' => currentUser(),
                ]);
                return;
            }
            $imagen = $resultado['ruta'];
        }

        (new Producto())->crear([
            'negocio_id' => $negocio_id,
            'categoria_id' => intval($_POST['categoria_id'] ?? 0) ?: null,
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => floatval($_POST['precio']),
            'imagen' => $imagen,
        ]);

        setFlash('exito', 'Producto creado');
        redirect('/panel/productos');
    }

    public function editar($id) {
        requireLogin();
        $producto = (new Producto())->porId($id, negocioId());
        if (!$producto) redirect('/panel/productos');

        $categorias = (new Categoria())->porNegocio(negocioId());
        renderModulo('catalogo', 'panel/producto-form', [
            'categorias' => $categorias,
            'producto' => $producto,
            'user' => currentUser(),
        ]);
    }

    public function actualizar($id) {
        requireLogin();
        $negocio_id = negocioId();
        $productoModel = new Producto();
        $producto = $productoModel->porId($id, $negocio_id);
        if (!$producto) redirect('/panel/productos');

        $errores = validar($_POST, [
            'nombre' => 'required|min:2|max:150',
            'precio' => 'required|numeric',
        ]);

        if ($errores) {
            $categorias = (new Categoria())->porNegocio($negocio_id);
            renderModulo('catalogo', 'panel/producto-form', [
                'categorias' => $categorias,
                'producto' => $producto,
                'errores' => $errores,
                'old' => $_POST,
                'user' => currentUser(),
            ]);
            return;
        }

        $data = [
            'categoria_id' => intval($_POST['categoria_id'] ?? 0) ?: null,
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => floatval($_POST['precio']),
        ];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $resultado = subirImagen('imagen', 'productos');
            if (isset($resultado['error'])) {
                $categorias = (new Categoria())->porNegocio($negocio_id);
                renderModulo('catalogo', 'panel/producto-form', [
                    'categorias' => $categorias,
                    'producto' => $producto,
                    'errores' => ['imagen' => $resultado['error']],
                    'old' => $_POST,
                    'user' => currentUser(),
                ]);
                return;
            }
            if ($producto['imagen']) borrarImagen($producto['imagen']);
            $data['imagen'] = $resultado['ruta'];
        }

        $productoModel->actualizar($id, $negocio_id, $data);
        setFlash('exito', 'Producto actualizado');
        redirect('/panel/productos');
    }

    public function eliminar($id) {
        requireLogin();
        (new Producto())->eliminar($id, negocioId());
        setFlash('exito', 'Producto eliminado');
        redirect('/panel/productos');
    }

    public function toggleDisponibilidad($id) {
        requireLogin();
        (new Producto())->toggleDisponibilidad($id, negocioId());
        back();
    }
}
