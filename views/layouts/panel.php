<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($titulo ?? 'Panel') ?> - <?= sanitize(APP_NAME) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=4">
</head>
<body class="panel-body">
    <div class="panel-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><?= sanitize(currentUser()['negocio_nombre'] ?? APP_NAME) ?></h2>
                <button class="sidebar-close" id="sidebar-close">&times;</button>
            </div>
            <nav class="sidebar-nav">
                <a href="/panel" class="sidebar-link <?= ($_SERVER['REQUEST_URI'] === '/panel') ? 'active' : '' ?>">
                    Dashboard
                </a>
                <?php foreach (menuModulos(negocioId()) as $item): ?>
                <a href="<?= $item['url'] ?>" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], $item['url']) === 0) ? 'active' : '' ?>">
                    <?= sanitize($item['label']) ?>
                </a>
                <?php endforeach; ?>
                <a href="/panel/config" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], '/panel/config') === 0) ? 'active' : '' ?>">
                    Ajustes
                </a>
            </nav>
            <div class="sidebar-footer">
                <span class="sidebar-user"><?= sanitize(currentUser()['nombre'] ?? '') ?></span>
                <form action="/logout" method="POST" style="display:inline">
                    <?= csrfField() ?>
                    <button type="submit" class="btn-logout">Cerrar sesion</button>
                </form>
            </div>
        </aside>

        <main class="panel-main">
            <header class="panel-header">
                <button class="sidebar-toggle" id="sidebar-toggle">&#9776;</button>
                <h1><?= sanitize($titulo ?? 'Panel') ?></h1>
            </header>

            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['tipo'] ?>">
                <?= sanitize($flash['mensaje']) ?>
            </div>
            <?php endif; ?>

            <div class="panel-content">
                <?= $content ?>
            </div>
        </main>
    </div>

    <script src="/assets/js/app.js?v=4"></script>
</body>
</html>
