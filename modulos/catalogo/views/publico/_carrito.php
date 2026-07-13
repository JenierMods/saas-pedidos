<?php if ($tienePedidos): ?>
<div class="carrito-flotante" id="carrito-flotante" style="display:none">
    <button class="carrito-btn" onclick="toggleCarrito()">
        <span id="carrito-count">0</span> items - <span id="carrito-total-btn"><?= $negocio['moneda'] ?> 0.00</span>
    </button>
</div>

<div class="carrito-panel" id="carrito-panel" style="display:none">
    <div class="carrito-header">
        <h3>Tu pedido</h3>
        <button onclick="toggleCarrito()" class="carrito-cerrar">&times;</button>
    </div>
    <div class="carrito-items" id="carrito-items">
        <p class="carrito-vacio">Tu carrito esta vacio. Agrega productos para hacer tu pedido.</p>
    </div>
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
