<?php

class Negocio {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function crear($data) {
        $stmt = $this->db->prepare("
            INSERT INTO negocios (nombre, slug, telefono, moneda)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['slug'],
            $data['telefono'],
            $data['moneda'] ?? 'C$',
        ]);
        return $this->db->lastInsertId();
    }

    public function porId($id) {
        $stmt = $this->db->prepare("SELECT * FROM negocios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function porSlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM negocios WHERE slug = ? AND activo = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function slugExiste($slug, $excluirId = null) {
        $sql = "SELECT COUNT(*) FROM negocios WHERE slug = ?";
        $params = [$slug];
        if ($excluirId) {
            $sql .= " AND id != ?";
            $params[] = $excluirId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function actualizar($id, $data) {
        $campos = [];
        $valores = [];
        foreach ($data as $campo => $valor) {
            $campos[] = "$campo = ?";
            $valores[] = $valor;
        }
        $valores[] = $id;
        $stmt = $this->db->prepare(
            "UPDATE negocios SET " . implode(', ', $campos) . " WHERE id = ?"
        );
        return $stmt->execute($valores);
    }

    public function activarModulos($negocio_id, $modulos) {
        $stmt = $this->db->prepare(
            "INSERT INTO negocio_modulos (negocio_id, modulo, activo) VALUES (?, ?, 1)"
        );
        foreach ($modulos as $modulo) {
            $stmt->execute([$negocio_id, $modulo]);
        }
    }
}
