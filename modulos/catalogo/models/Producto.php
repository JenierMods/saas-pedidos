<?php

class Producto {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function porNegocio($negocio_id, $page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre
            FROM productos p
            LEFT JOIN categorias_catalogo c ON p.categoria_id = c.id
            WHERE p.negocio_id = ?
            ORDER BY p.orden ASC, p.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$negocio_id, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function contar($negocio_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE negocio_id = ?");
        $stmt->execute([$negocio_id]);
        return (int) $stmt->fetchColumn();
    }

    public function porId($id, $negocio_id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ? AND negocio_id = ?");
        $stmt->execute([$id, $negocio_id]);
        return $stmt->fetch();
    }

    public function crear($data) {
        $stmt = $this->db->prepare("
            INSERT INTO productos (negocio_id, categoria_id, nombre, descripcion, precio, imagen, disponible)
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ");
        $stmt->execute([
            $data['negocio_id'],
            $data['categoria_id'] ?: null,
            $data['nombre'],
            $data['descripcion'] ?? '',
            $data['precio'],
            $data['imagen'] ?? null,
        ]);
        return $this->db->lastInsertId();
    }

    public function actualizar($id, $negocio_id, $data) {
        $campos = [];
        $valores = [];
        foreach ($data as $campo => $valor) {
            $campos[] = "$campo = ?";
            $valores[] = $valor;
        }
        $valores[] = $id;
        $valores[] = $negocio_id;
        $stmt = $this->db->prepare(
            "UPDATE productos SET " . implode(', ', $campos) . " WHERE id = ? AND negocio_id = ?"
        );
        return $stmt->execute($valores);
    }

    public function eliminar($id, $negocio_id) {
        $producto = $this->porId($id, $negocio_id);
        if ($producto && $producto['imagen']) {
            borrarImagen($producto['imagen']);
        }
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ? AND negocio_id = ?");
        return $stmt->execute([$id, $negocio_id]);
    }

    public function toggleDisponibilidad($id, $negocio_id) {
        $stmt = $this->db->prepare(
            "UPDATE productos SET disponible = NOT disponible WHERE id = ? AND negocio_id = ?"
        );
        return $stmt->execute([$id, $negocio_id]);
    }

    public function porIdPublico($id, $negocio_id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre
            FROM productos p
            LEFT JOIN categorias_catalogo c ON p.categoria_id = c.id
            WHERE p.id = ? AND p.negocio_id = ? AND p.disponible = 1
        ");
        $stmt->execute([$id, $negocio_id]);
        return $stmt->fetch();
    }

    public function relacionados($negocio_id, $categoria_id, $excluir_id, $limit = 4) {
        if ($categoria_id) {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre
                FROM productos p
                LEFT JOIN categorias_catalogo c ON p.categoria_id = c.id
                WHERE p.negocio_id = ? AND p.disponible = 1 AND p.categoria_id = ? AND p.id != ?
                ORDER BY RAND()
                LIMIT ?
            ");
            $stmt->execute([$negocio_id, $categoria_id, $excluir_id, $limit]);
        } else {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre
                FROM productos p
                LEFT JOIN categorias_catalogo c ON p.categoria_id = c.id
                WHERE p.negocio_id = ? AND p.disponible = 1 AND p.id != ?
                ORDER BY RAND()
                LIMIT ?
            ");
            $stmt->execute([$negocio_id, $excluir_id, $limit]);
        }
        return $stmt->fetchAll();
    }

    public function publicosPorNegocio($negocio_id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre
            FROM productos p
            LEFT JOIN categorias_catalogo c ON p.categoria_id = c.id
            WHERE p.negocio_id = ? AND p.disponible = 1
            ORDER BY c.orden ASC, p.orden ASC, p.nombre ASC
        ");
        $stmt->execute([$negocio_id]);
        return $stmt->fetchAll();
    }
}
