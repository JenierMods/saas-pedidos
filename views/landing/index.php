<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Tu negocio en linea</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="landing-body">
    <nav class="landing-nav">
        <a href="/" class="landing-logo"><?= sanitize(APP_NAME) ?></a>
        <div class="landing-nav-links">
            <a href="/login">Iniciar sesion</a>
            <a href="/registro" class="btn btn-primary btn-sm">Crear cuenta gratis</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Tu catalogo web y pedidos por WhatsApp</h1>
            <p>Crea tu tienda en linea en minutos. Tus clientes ven tus productos y te hacen pedidos directo a tu WhatsApp.</p>
            <a href="/registro" class="btn btn-primary btn-lg">Comenzar gratis</a>
        </div>
    </section>

    <section class="features">
        <div class="features-grid">
            <div class="feature-card">
                <h3>Catalogo web</h3>
                <p>Sube tus productos con fotos, precios y categorias. Comparte el enlace con tus clientes.</p>
            </div>
            <div class="feature-card">
                <h3>Pedidos por WhatsApp</h3>
                <p>Tus clientes arman su pedido y te lo envian directo a tu WhatsApp. Sin comisiones.</p>
            </div>
            <div class="feature-card">
                <h3>Panel de control</h3>
                <p>Gestiona tus productos, pedidos y ajustes desde un panel facil de usar.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Empieza hoy, es gratis</h2>
        <p>No necesitas tarjeta de credito. Crea tu cuenta y ten tu tienda lista en minutos.</p>
        <a href="/registro" class="btn btn-primary btn-lg">Crear mi tienda</a>
    </section>

    <footer class="landing-footer">
        <p>&copy; <?= date('Y') ?> <?= sanitize(APP_NAME) ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
