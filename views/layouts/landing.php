<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($titulo ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="landing-body">
    <nav class="landing-nav">
        <a href="/" class="landing-logo"><?= sanitize(APP_NAME) ?></a>
        <div class="landing-nav-links">
            <a href="/login">Iniciar sesion</a>
            <a href="/registro" class="btn btn-primary btn-sm">Crear cuenta</a>
        </div>
    </nav>

    <main class="landing-main">
        <?= $content ?>
    </main>

    <footer class="landing-footer">
        <p>&copy; <?= date('Y') ?> <?= sanitize(APP_NAME) ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
