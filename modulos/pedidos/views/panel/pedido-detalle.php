<?php $titulo = 'Pedido #' . $pedido['numero']; ?>

<div class="pedido-detalle">
    <div class="pedido-info-grid">
        <div class="pedido-info-card">
            <h3>Datos del cliente</h3>
            <p><strong>Nombre:</strong> <?= sanitize($pedido['cliente_nombre']) ?></p>
            <p><strong>Telefono:</strong> <?= sanitize($pedido['cliente_telefono']) ?></p>
            <?php if ($pedido['cliente_direccion']): ?>
            <p><strong>Direccion:</strong> <?= sanitize($pedido['cliente_direccion']) ?></p>
            <?php endif; ?>
            <p><strong>Entrega:</strong> <?= $pedido['metodo_entrega'] === 'delivery' ? 'Delivery' : 'Recoger en tienda' ?></p>
            <?php if ($pedido['nota']): ?>
            <p><strong>Nota:</strong> <?= sanitize($pedido['nota']) ?></p>
            <?php endif; ?>
            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></p>
        </div>

        <div class="pedido-info-card">
            <h3>Estado</h3>
            <p><span class="badge badge-<?= $pedido['estado'] ?>"><?= ucfirst($pedido['estado']) ?></span></p>

            <?php if ($pedido['estado'] !== 'entregado' && $pedido['estado'] !== 'cancelado'): ?>
            <form method="POST" action="/panel/pedidos/<?= $pedido['id'] ?>/estado" class="estado-form">
                <?= csrfField() ?>
                <select name="estado">
                    <option value="nuevo" <?= $pedido['estado'] === 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
                    <option value="preparando" <?= $pedido['estado'] === 'preparando' ? 'selected' : '' ?>>Preparando</option>
                    <option value="listo" <?= $pedido['estado'] === 'listo' ? 'selected' : '' ?>>Listo</option>
                    <option value="entregado" <?= $pedido['estado'] === 'entregado' ? 'selected' : '' ?>>Entregado</option>
                    <option value="cancelado" <?= $pedido['estado'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Cambiar</button>
            </form>
            <?php endif; ?>

            <?php
            $waNumero = preg_replace('/[^0-9]/', '', $pedido['cliente_telefono']);
            if ($waNumero):
            ?>
            <a href="https://wa.me/<?= $waNumero ?>" target="_blank" class="btn btn-success btn-sm" style="margin-top:8px">Escribir por WhatsApp</a>
            <?php endif; ?>
        </div>
    </div>

    <h3>Productos</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $moneda = $user['moneda'] ?? 'C$'; ?>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= sanitize($item['nombre_producto']) ?></td>
                    <td><?= $moneda ?> <?= number_format($item['precio'], 2) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= $moneda ?> <?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= $moneda ?> <?= number_format($pedido['total'], 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="/panel/pedidos" class="btn btn-secondary">Volver a pedidos</a>
</div>
