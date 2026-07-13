<?php

require_once BASE_PATH . '/modulos/catalogo/models/Producto.php';
require_once BASE_PATH . '/modulos/catalogo/models/Categoria.php';
require_once BASE_PATH . '/modulos/catalogo/models/ProductoImagen.php';

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
                'imagenes' => [],
                'errores' => $errores,
                'old' => $_POST,
                'user' => currentUser(),
            ]);
            return;
        }

        $rutas = [];
        if (isset($_FILES['imagenes']) && is_array($_FILES['imagenes']['name'])) {
            $resultado = subirMultiplesImagenes('imagenes', 'productos', 5);
            if (isset($resultado['error'])) {
                $categorias = (new Categoria())->porNegocio($negocio_id);
                renderModulo('catalogo', 'panel/producto-form', [
                    'categorias' => $categorias,
                    'producto' => null,
                    'imagenes' => [],
                    'errores' => ['imagenes' => $resultado['error']],
                    'old' => $_POST,
                    'user' => currentUser(),
                ]);
                return;
            }
            $rutas = $resultado;
        }

        $imagenPrincipal = !empty($rutas) ? $rutas[0] : null;

        $productoId = (new Producto())->crear([
            'negocio_id' => $negocio_id,
            'categoria_id' => intval($_POST['categoria_id'] ?? 0) ?: null,
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => floatval($_POST['precio']),
            'imagen' => $imagenPrincipal,
        ]);

        $imagenModel = new ProductoImagen();
        foreach ($rutas as $orden => $ruta) {
            $imagenModel->agregar($productoId, $ruta, $orden);
        }

        setFlash('exito', 'Producto creado');
        redirect('/panel/productos');
    }

    public function editar($id) {
        requireLogin();
        $negocio_id = negocioId();
        $producto = (new Producto())->porId($id, $negocio_id);
        if (!$producto) redirect('/panel/productos');

        $categorias = (new Categoria())->porNegocio($negocio_id);
        $imagenes = (new ProductoImagen())->porProducto($id);
        renderModulo('catalogo', 'panel/producto-form', [
            'categorias' => $categorias,
            'producto' => $producto,
            'imagenes' => $imagenes,
            'user' => currentUser(),
        ]);
    }

    public function actualizar($id) {
        requireLogin();
        $negocio_id = negocioId();
        $productoModel = new Producto();
        $imagenModel = new ProductoImagen();
        $producto = $productoModel->porId($id, $negocio_id);
        if (!$producto) redirect('/panel/productos');

        $errores = validar($_POST, [
            'nombre' => 'required|min:2|max:150',
            'precio' => 'required|numeric',
        ]);

        $imagenesExistentes = $imagenModel->porProducto($id);

        if ($errores) {
            $categorias = (new Categoria())->porNegocio($negocio_id);
            renderModulo('catalogo', 'panel/producto-form', [
                'categorias' => $categorias,
                'producto' => $producto,
                'imagenes' => $imagenesExistentes,
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

        $cantidadExistente = count($imagenesExistentes);

        if (isset($_FILES['imagenes']) && is_array($_FILES['imagenes']['name'])) {
            $nuevas = 0;
            foreach ($_FILES['imagenes']['error'] as $err) {
                if ($err === UPLOAD_ERR_OK) $nuevas++;
            }

            if (($cantidadExistente + $nuevas) > 5) {
                $categorias = (new Categoria())->porNegocio($negocio_id);
                renderModulo('catalogo', 'panel/producto-form', [
                    'categorias' => $categorias,
                    'producto' => $producto,
                    'imagenes' => $imagenesExistentes,
                    'errores' => ['imagenes' => 'El producto ya tiene ' . $cantidadExistente . ' imagenes. Solo puedes agregar ' . (5 - $cantidadExistente) . ' mas.'],
                    'old' => $_POST,
                    'user' => currentUser(),
                ]);
                return;
            }

            if ($nuevas > 0) {
                $resultado = subirMultiplesImagenes('imagenes', 'productos', 5);
                if (isset($resultado['error'])) {
                    $categorias = (new Categoria())->porNegocio($negocio_id);
                    renderModulo('catalogo', 'panel/producto-form', [
                        'categorias' => $categorias,
                        'producto' => $producto,
                        'imagenes' => $imagenesExistentes,
                        'errores' => ['imagenes' => $resultado['error']],
                        'old' => $_POST,
                        'user' => currentUser(),
                    ]);
                    return;
                }

                $orden = $cantidadExistente;
                foreach ($resultado as $ruta) {
                    $imagenModel->agregar($id, $ruta, $orden++);
                }

                if ($cantidadExistente === 0) {
                    $data['imagen'] = $resultado[0];
                }
            }
        }

        $productoModel->actualizar($id, $negocio_id, $data);
        setFlash('exito', 'Producto actualizado');
        redirect('/panel/productos');
    }

    public function eliminar($id) {
        requireLogin();
        $negocio_id = negocioId();
        (new ProductoImagen())->eliminarTodasDeProducto($id);
        (new Producto())->eliminar($id, $negocio_id);
        setFlash('exito', 'Producto eliminado');
        redirect('/panel/productos');
    }

    public function eliminarImagen($id) {
        requireLogin();
        $negocio_id = negocioId();
        $productoId = intval($_POST['producto_id'] ?? 0);

        $productoModel = new Producto();
        $producto = $productoModel->porId($productoId, $negocio_id);
        if (!$producto) redirect('/panel/productos');

        $imagenModel = new ProductoImagen();
        $imagenModel->eliminar($id, $productoId);

        $restantes = $imagenModel->porProducto($productoId);
        $nuevaPrincipal = !empty($restantes) ? $restantes[0]['imagen'] : null;
        $productoModel->actualizar($productoId, $negocio_id, ['imagen' => $nuevaPrincipal]);

        setFlash('exito', 'Imagen eliminada');
        redirect('/panel/productos/editar/' . $productoId);
    }

    public function toggleDisponibilidad($id) {
        requireLogin();
        (new Producto())->toggleDisponibilidad($id, negocioId());
        back();
    }
}
