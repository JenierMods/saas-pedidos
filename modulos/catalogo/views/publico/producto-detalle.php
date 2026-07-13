<?php $moneda = $negocio['moneda'] ?? 'C$'; ?>

<nav class="producto-breadcrumb">
    <a href="/tienda/<?= sanitize($negocio['slug']) ?>">Catalogo</a>
    <?php if ($producto['categoria_nombre']): ?>
    <span class="breadcrumb-sep">/</span>
    <span><?= sanitize($producto['categoria_nombre']) ?></span>
    <?php endif; ?>
    <span class="breadcrumb-sep">/</span>
    <span><?= sanitize($producto['nombre']) ?></span>
</nav>

<div class="producto-detalle-grid">
    <div class="producto-detalle-imagen">
        <?php if ($producto['imagen']): ?>
        <img src="/uploads/<?= sanitize($producto['imagen']) ?>" alt="<?= sanitize($producto['nombre']) ?>" class="producto-detalle-img">
        <?php else: ?>
        <div class="producto-detalle-img-placeholder"></div>
        <?php endif; ?>
    </div>

    <div class="producto-detalle-info">
        <?php if ($producto['categoria_nombre']): ?>
        <span class="producto-detalle-categoria"><?= sanitize($producto['categoria_nombre']) ?></span>
        <?php endif; ?>

        <h1 class="producto-detalle-nombre"><?= sanitize($producto['nombre']) ?></h1>

        <span class="producto-detalle-precio"><?= $moneda ?> <?= number_format($producto['precio'], 2) ?></span>

        <?php if ($producto['descripcion']): ?>
        <div class="producto-detalle-descripcion"><?= nl2br(sanitize($producto['descripcion'])) ?></div>
        <?php endif; ?>

        <?php if ($tienePedidos): ?>
        <div class="producto-detalle-comprar">
            <div class="cantidad-selector">
                <button type="button" onclick="cambiarCantidadDetalle(-1)">-</button>
                <span id="cantidad-detalle">1</span>
                <button type="button" onclick="cambiarCantidadDetalle(1)">+</button>
            </div>
            <button class="btn btn-primary btn-lg btn-block btn-agregar-detalle" onclick="agregarDesdeDetalle(<?= $producto['id'] ?>, '<?= sanitize($producto['nombre']) ?>', <?= $producto['precio'] ?>)">
                Agregar al carrito
            </button>
        </div>
        <script>
        var cantidadDetalle = 1;
        function cambiarCantidadDetalle(delta) {
            cantidadDetalle += delta;
            if (cantidadDetalle < 1) cantidadDetalle = 1;
            document.getElementById('cantidad-detalle').textContent = cantidadDetalle;
        }
        function agregarDesdeDetalle(id, nombre, precio) {
            agregarAlCarrito(id, nombre, precio, cantidadDetalle);
            cantidadDetalle = 1;
            document.getElementById('cantidad-detalle').textContent = 1;
            var btn = document.querySelector('.btn-agregar-detalle');
            btn.textContent = 'Agregado al carrito';
            btn.classList.add('btn-agregado');
            setTimeout(function() {
                btn.textContent = 'Agregar al carrito';
                btn.classList.remove('btn-agregado');
            }, 1500);
        }
        </script>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($relacionados)): ?>
<div class="productos-relacionados">
    <h2>Tambien te puede interesar</h2>
    <div class="productos-grid">
        <?php foreach ($relacionados as $p): ?>
        <div class="producto-card">
            <a href="/tienda/<?= sanitize($negocio['slug']) ?>/producto/<?= $p['id'] ?>" class="producto-card-link">
                <?php if ($p['imagen']): ?>
                <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="<?= sanitize($p['nombre']) ?>" class="producto-img">
                <?php else: ?>
                <div class="producto-img-placeholder"></div>
                <?php endif; ?>
                <div class="producto-info">
                    <h3><?= sanitize($p['nombre']) ?></h3>
                    <span class="producto-precio"><?= $moneda ?> <?= number_format($p['precio'], 2) ?></span>
                </div>
            </a>
            <?php if ($tienePedidos): ?>
            <div class="producto-actions">
                <button class="btn btn-primary btn-sm btn-agregar" onclick="agregarAlCarrito(<?= $p['id'] ?>, '<?= sanitize($p['nombre']) ?>', <?= $p['precio'] ?>)">Agregar</button>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php require __DIR__ . '/_carrito.php'; ?>
