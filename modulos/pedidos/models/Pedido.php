<?php

class Pedido {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function crear($data) {
        $numero = $this->siguienteNumero($data['negocio_id']);

        $stmt = $this->db->prepare("
            INSERT INTO pedidos (negocio_id, numero, cliente_nombre, cliente_telefono, cliente_direccion, nota, total, metodo_entrega)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['negocio_id'],
            $numero,
            $data['cliente_nombre'],
            $data['cliente_telefono'],
            $data['cliente_direccion'] ?? null,
            $data['nota'] ?? null,
            $data['total'],
            $data['metodo_entrega'] ?? 'delivery',
        ]);
        return $this->db->lastInsertId();
    }

    public function agregarItem($pedido_id, $item) {
        $stmt = $this->db->prepare("
            INSERT INTO pedido_items (pedido_id, producto_id, nombre_producto, precio, cantidad, subtotal)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $pedido_id,
            $item['producto_id'] ?? null,
            $item['nombre_producto'],
            $item['precio'],
            $item['cantidad'],
            $item['precio'] * $item['cantidad'],
        ]);
    }

    public function porNegocio($negocio_id, $estado = null, $page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM pedidos WHERE negocio_id = ?";
        $params = [$negocio_id];

        if ($estado) {
            $sql .= " AND estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function contar($negocio_id, $estado = null) {
        $sql = "SELECT COUNT(*) FROM pedidos WHERE negocio_id = ?";
        $params = [$negocio_id];
        if ($estado) {
            $sql .= " AND estado = ?";
            $params[] = $estado;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function porId($id, $negocio_id) {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id = ? AND negocio_id = ?");
        $stmt->execute([$id, $negocio_id]);
        return $stmt->fetch();
    }

    public function items($pedido_id) {
        $stmt = $this->db->prepare("SELECT * FROM pedido_items WHERE pedido_id = ?");
        $stmt->execute([$pedido_id]);
        return $stmt->fetchAll();
    }

    public function cambiarEstado($id, $negocio_id, $estado) {
        $validos = ['nuevo', 'preparando', 'listo', 'entregado', 'cancelado'];
        if (!in_array($estado, $validos)) return false;

        $stmt = $this->db->prepare("UPDATE pedidos SET estado = ? WHERE id = ? AND negocio_id = ?");
        return $stmt->execute([$estado, $id, $negocio_id]);
    }

    public function ventasHoy($negocio_id) {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(total), 0) FROM pedidos WHERE negocio_id = ? AND DATE(created_at) = CURDATE() AND estado != 'cancelado'"
        );
        $stmt->execute([$negocio_id]);
        return (float) $stmt->fetchColumn();
    }

    private function siguienteNumero($negocio_id) {
        $stmt = $this->db->prepare("SELECT COALESCE(MAX(numero), 0) + 1 FROM pedidos WHERE negocio_id = ?");
        $stmt->execute([$negocio_id]);
        return (int) $stmt->fetchColumn();
    }
}
