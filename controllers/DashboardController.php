<?php

class DashboardController {

    public function index() {
        requireLogin();
        $negocio_id = negocioId();
        $db = getDB();

        $stats = [
            'productos' => 0,
            'pedidos_hoy' => 0,
            'ventas_hoy' => 0,
            'pedidos_nuevos' => 0,
        ];

        if (tieneModulo($negocio_id, 'catalogo')) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM productos WHERE negocio_id = ?");
            $stmt->execute([$negocio_id]);
            $stats['productos'] = (int) $stmt->fetchColumn();
        }

        if (tieneModulo($negocio_id, 'pedidos')) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM pedidos WHERE negocio_id = ? AND DATE(created_at) = CURDATE()");
            $stmt->execute([$negocio_id]);
            $stats['pedidos_hoy'] = (int) $stmt->fetchColumn();

            $stmt = $db->prepare("SELECT COALESCE(SUM(total), 0) FROM pedidos WHERE negocio_id = ? AND DATE(created_at) = CURDATE() AND estado != 'cancelado'");
            $stmt->execute([$negocio_id]);
            $stats['ventas_hoy'] = (float) $stmt->fetchColumn();

            $stmt = $db->prepare("SELECT COUNT(*) FROM pedidos WHERE negocio_id = ? AND estado = 'nuevo'");
            $stmt->execute([$negocio_id]);
            $stats['pedidos_nuevos'] = (int) $stmt->fetchColumn();
        }

        $user = currentUser();
        render('panel/dashboard', [
            'stats' => $stats,
            'user' => $user,
        ]);
    }
}
