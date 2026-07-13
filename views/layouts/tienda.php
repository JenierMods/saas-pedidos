<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($negocio['nombre'] ?? 'Tienda') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=2">
</head>
<body class="tienda-body">
    <header class="tienda-header">
        <div class="tienda-header-inner">
            <?php if (!empty($negocio['logo'])): ?>
            <img src="/uploads/<?= sanitize($negocio['logo']) ?>" alt="Logo" class="tienda-logo-img">
            <?php endif; ?>
            <div>
                <h1 class="tienda-nombre"><?= sanitize($negocio['nombre'] ?? '') ?></h1>
                <?php if (!empty($negocio['telefono'])): ?>
                <p class="tienda-telefono"><?= sanitize($negocio['telefono']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="tienda-main">
        <?= $content ?>
    </main>

    <footer class="tienda-footer">
        <p>Creado con <?= sanitize(APP_NAME) ?></p>
    </footer>

    <script src="/assets/js/app.js?v=2"></script>
</body>
</html>
