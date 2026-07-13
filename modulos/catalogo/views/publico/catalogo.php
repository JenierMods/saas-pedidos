<?php if ($totalProductos === 0): ?>
<div class="empty-state">
    <p>Este negocio aun no tiene productos.</p>
</div>
<?php else: ?>

<?php if (!empty($sinCategoria)): ?>
<div class="catalogo-seccion">
    <div class="productos-grid">
        <?php foreach ($sinCategoria as $p): ?>
        <div class="producto-card">
            <a href="/tienda/<?= sanitize($negocio['slug']) ?>/producto/<?= $p['id'] ?>" class="producto-card-link">
                <?php if ($p['imagen']): ?>
                <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="<?= sanitize($p['nombre']) ?>" class="producto-img">
                <?php else: ?>
                <div class="producto-img-placeholder"></div>
                <?php endif; ?>
                <div class="producto-info">
                    <h3><?= sanitize($p['nombre']) ?></h3>
                    <?php if ($p['descripcion']): ?>
                    <p class="producto-desc"><?= sanitize(mb_strimwidth($p['descripcion'], 0, 80, '...')) ?></p>
                    <?php endif; ?>
                    <span class="producto-precio"><?= $negocio['moneda'] ?> <?= number_format($p['precio'], 2) ?></span>
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

<?php foreach ($porCategoria as $catNombre => $productos): ?>
<div class="catalogo-seccion">
    <h2 class="catalogo-categoria"><?= sanitize($catNombre) ?></h2>
    <div class="productos-grid">
        <?php foreach ($productos as $p): ?>
        <div class="producto-card">
            <a href="/tienda/<?= sanitize($negocio['slug']) ?>/producto/<?= $p['id'] ?>" class="producto-card-link">
                <?php if ($p['imagen']): ?>
                <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="<?= sanitize($p['nombre']) ?>" class="producto-img">
                <?php else: ?>
                <div class="producto-img-placeholder"></div>
                <?php endif; ?>
                <div class="producto-info">
                    <h3><?= sanitize($p['nombre']) ?></h3>
                    <?php if ($p['descripcion']): ?>
                    <p class="producto-desc"><?= sanitize(mb_strimwidth($p['descripcion'], 0, 80, '...')) ?></p>
                    <?php endif; ?>
                    <span class="producto-precio"><?= $negocio['moneda'] ?> <?= number_format($p['precio'], 2) ?></span>
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
<?php endforeach; ?>

<?php require __DIR__ . '/_carrito.php'; ?>

<?php endif; ?>
