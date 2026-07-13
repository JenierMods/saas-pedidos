<?php

class AuthController {

    public function loginForm() {
        if (isLoggedIn()) redirect('/panel');
        render('auth/login', [], 'landing');
    }

    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            render('auth/login', ['error' => 'Completa todos los campos'], 'landing');
            return;
        }

        $usuario = new Usuario();
        $user = $usuario->verificarPassword($email, $password);

        if (!$user) {
            render('auth/login', ['error' => 'Email o contrasena incorrectos', 'email' => $email], 'landing');
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['negocio_id'] = $user['negocio_id'];
        redirect('/panel');
    }

    public function registroForm() {
        if (isLoggedIn()) redirect('/panel');
        render('auth/registro', [], 'landing');
    }

    public function registro() {
        $errores = validar($_POST, [
            'nombre_negocio' => 'required|min:2|max:100',
            'nombre' => 'required|min:2|max:100',
            'email' => 'required|email',
            'telefono' => 'required|min:8|max:20',
            'password' => 'required|min:6',
        ]);

        if ($_POST['password'] !== ($_POST['password_confirm'] ?? '')) {
            $errores['password_confirm'] = 'Las contrasenas no coinciden';
        }

        $usuario = new Usuario();
        if ($usuario->emailExiste(trim($_POST['email']))) {
            $errores['email'] = 'Este email ya esta registrado';
        }

        if ($errores) {
            render('auth/registro', ['errores' => $errores, 'old' => $_POST], 'landing');
            return;
        }

        $db = getDB();
        $db->beginTransaction();

        try {
            $negocio = new Negocio();
            $slugBase = slug($_POST['nombre_negocio']);
            $slugFinal = $slugBase;
            $i = 1;
            while ($negocio->slugExiste($slugFinal)) {
                $slugFinal = $slugBase . '-' . $i++;
            }

            $negocioId = $negocio->crear([
                'nombre' => trim($_POST['nombre_negocio']),
                'slug' => $slugFinal,
                'telefono' => trim($_POST['telefono']),
            ]);

            $userId = $usuario->crear([
                'negocio_id' => $negocioId,
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'rol' => 'dueno',
            ]);

            $negocio->activarModulos($negocioId, ['catalogo', 'pedidos']);

            $db->commit();

            $_SESSION['user_id'] = $userId;
            $_SESSION['negocio_id'] = $negocioId;
            setFlash('exito', 'Cuenta creada. Bienvenido a ' . APP_NAME);
            redirect('/panel');

        } catch (Exception $e) {
            $db->rollBack();
            render('auth/registro', [
                'errores' => ['general' => 'Error al crear la cuenta. Intenta de nuevo.'],
                'old' => $_POST,
            ], 'landing');
        }
    }

    public function logout() {
        session_destroy();
        redirect('/login');
    }
}
