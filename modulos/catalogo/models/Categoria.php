<?php

class Categoria {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function porNegocio($negocio_id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM categorias_catalogo WHERE negocio_id = ? ORDER BY orden ASC, nombre ASC"
        );
        $stmt->execute([$negocio_id]);
        return $stmt->fetchAll();
    }

    public function crear($negocio_id, $nombre) {
        $stmt = $this->db->prepare(
            "INSERT INTO categorias_catalogo (negocio_id, nombre) VALUES (?, ?)"
        );
        $stmt->execute([$negocio_id, $nombre]);
        return $this->db->lastInsertId();
    }

    public function eliminar($id, $negocio_id) {
        $stmt = $this->db->prepare(
            "DELETE FROM categorias_catalogo WHERE id = ? AND negocio_id = ?"
        );
        return $stmt->execute([$id, $negocio_id]);
    }

    public function tieneProductos($id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
