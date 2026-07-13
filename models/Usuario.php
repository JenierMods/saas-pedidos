<?php

class Usuario {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function crear($data) {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (negocio_id, nombre, email, password, rol)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['negocio_id'],
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['rol'] ?? 'dueno',
        ]);
        return $this->db->lastInsertId();
    }

    public function porEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function porId($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function emailExiste($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function verificarPassword($email, $password) {
        $user = $this->porEmail($email);
        if (!$user) return false;
        if (!password_verify($password, $user['password'])) return false;
        return $user;
    }
}
