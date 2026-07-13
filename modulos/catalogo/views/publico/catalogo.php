<?php if ($totalProductos === 0): ?>
<div class="empty-state">
    <p>Este negocio aun no tiene productos.</p>
</div>
<?php else: ?>

<?php if (!empty($sinCategoria)): ?>
<div class="catalogo-seccion">
    <div class="productos-grid">
        <?php foreach ($sinCategoria as $p): ?>
        <div class="producto-card" data-id="<?= $p['id'] ?>" data-nombre="<?= sanitize($p['nombre']) ?>" data-precio="<?= $p['precio'] ?>">
            <?php if ($p['imagen']): ?>
            <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="<?= sanitize($p['nombre']) ?>" class="producto-img">
            <?php else: ?>
            <div class="producto-img-placeholder"></div>
            <?php endif; ?>
            <div class="producto-info">
                <h3><?= sanitize($p['nombre']) ?></h3>
                <?php if ($p['descripcion']): ?>
                <p class="producto-desc"><?= sanitize($p['descripcion']) ?></p>
                <?php endif; ?>
                <span class="producto-precio"><?= $negocio['moneda'] ?> <?= number_format($p['precio'], 2) ?></span>
                <?php if ($tienePedidos): ?>
                <button class="btn btn-primary btn-sm btn-agregar" onclick="agregarAlCarrito(<?= $p['id'] ?>, '<?= sanitize($p['nombre']) ?>', <?= $p['precio'] ?>)">Agregar</button>
                <?php endif; ?>
            </div>
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
        <div class="producto-card" data-id="<?= $p['id'] ?>" data-nombre="<?= sanitize($p['nombre']) ?>" data-precio="<?= $p['precio'] ?>">
            <?php if ($p['imagen']): ?>
            <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="<?= sanitize($p['nombre']) ?>" class="producto-img">
            <?php else: ?>
            <div class="producto-img-placeholder"></div>
            <?php endif; ?>
            <div class="producto-info">
                <h3><?= sanitize($p['nombre']) ?></h3>
                <?php if ($p['descripcion']): ?>
                <p class="producto-desc"><?= sanitize($p['descripcion']) ?></p>
                <?php endif; ?>
                <span class="producto-precio"><?= $negocio['moneda'] ?> <?= number_format($p['precio'], 2) ?></span>
                <?php if ($tienePedidos): ?>
                <button class="btn btn-primary btn-sm btn-agregar" onclick="agregarAlCarrito(<?= $p['id'] ?>, '<?= sanitize($p['nombre']) ?>', <?= $p['precio'] ?>)">Agregar</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<?php if ($tienePedidos): ?>
<div class="carrito-flotante" id="carrito-flotante" style="display:none">
    <button class="carrito-btn" onclick="toggleCarrito()">
        <span id="carrito-count">0</span> items
    </button>
</div>

<div class="carrito-panel" id="carrito-panel" style="display:none">
    <div class="carrito-header">
        <h3>Tu pedido</h3>
        <button onclick="toggleCarrito()" class="carrito-cerrar">&times;</button>
    </div>
    <div class="carrito-items" id="carrito-items"></div>
    <div class="carrito-total">
        <strong>Total: <span id="carrito-total"><?= $negocio['moneda'] ?> 0.00</span></strong>
    </div>
    <form id="pedido-form" class="carrito-form">
        <input type="text" name="cliente_nombre" placeholder="Tu nombre" required>
        <input type="tel" name="cliente_telefono" placeholder="Tu telefono" required>
        <input type="text" name="cliente_direccion" placeholder="Direccion de entrega">
        <textarea name="nota" placeholder="Nota adicional" rows="2"></textarea>
        <select name="metodo_entrega">
            <option value="delivery">Delivery</option>
            <option value="recoger">Recoger en tienda</option>
        </select>
        <button type="submit" class="btn btn-primary btn-block">Enviar pedido por WhatsApp</button>
    </form>
</div>

<script>
var carritoSlug = '<?= sanitize($negocio['slug']) ?>';
var carritoMoneda = '<?= sanitize($negocio['moneda']) ?>';
var carritoTelefono = '<?= sanitize($negocio['telefono']) ?>';
</script>
<?php endif; ?>

<?php endif; ?>
