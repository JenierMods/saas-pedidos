<?php

class ProductoImagen {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function porProducto($producto_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM producto_imagenes
            WHERE producto_id = ?
            ORDER BY orden ASC, id ASC
        ");
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll();
    }

    public function agregar($producto_id, $imagen, $orden = 0) {
        $stmt = $this->db->prepare("
            INSERT INTO producto_imagenes (producto_id, imagen, orden)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$producto_id, $imagen, $orden]);
        return $this->db->lastInsertId();
    }

    public function eliminar($id, $producto_id) {
        $stmt = $this->db->prepare("SELECT imagen FROM producto_imagenes WHERE id = ? AND producto_id = ?");
        $stmt->execute([$id, $producto_id]);
        $img = $stmt->fetch();
        if ($img) {
            borrarImagen($img['imagen']);
            $stmt = $this->db->prepare("DELETE FROM producto_imagenes WHERE id = ? AND producto_id = ?");
            $stmt->execute([$id, $producto_id]);
            return true;
        }
        return false;
    }

    public function contarPorProducto($producto_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM producto_imagenes WHERE producto_id = ?");
        $stmt->execute([$producto_id]);
        return (int) $stmt->fetchColumn();
    }

    public function eliminarTodasDeProducto($producto_id) {
        $imagenes = $this->porProducto($producto_id);
        foreach ($imagenes as $img) {
            borrarImagen($img['imagen']);
        }
        $stmt = $this->db->prepare("DELETE FROM producto_imagenes WHERE producto_id = ?");
        $stmt->execute([$producto_id]);
    }
}
