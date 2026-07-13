<?php $titulo = 'Pedidos'; ?>

<div class="tabs">
    <a href="/panel/pedidos" class="tab <?= !$estado ? 'active' : '' ?>">Todos (<?= $conteos['todos'] ?>)</a>
    <a href="/panel/pedidos?estado=nuevo" class="tab <?= $estado === 'nuevo' ? 'active' : '' ?>">Nuevos (<?= $conteos['nuevo'] ?>)</a>
    <a href="/panel/pedidos?estado=preparando" class="tab <?= $estado === 'preparando' ? 'active' : '' ?>">Preparando (<?= $conteos['preparando'] ?>)</a>
    <a href="/panel/pedidos?estado=listo" class="tab <?= $estado === 'listo' ? 'active' : '' ?>">Listos (<?= $conteos['listo'] ?>)</a>
    <a href="/panel/pedidos?estado=entregado" class="tab <?= $estado === 'entregado' ? 'active' : '' ?>">Entregados (<?= $conteos['entregado'] ?>)</a>
    <a href="/panel/pedidos?estado=cancelado" class="tab <?= $estado === 'cancelado' ? 'active' : '' ?>">Cancelados (<?= $conteos['cancelado'] ?>)</a>
</div>

<?php if (empty($pedidos)): ?>
<div class="empty-state">
    <p>No hay pedidos<?= $estado ? ' con estado "' . sanitize($estado) . '"' : '' ?>.</p>
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Entrega</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['numero'] ?></td>
                <td>
                    <strong><?= sanitize($p['cliente_nombre']) ?></strong><br>
                    <small><?= sanitize($p['cliente_telefono']) ?></small>
                </td>
                <td><?= sanitize($user['moneda'] ?? 'C$') ?> <?= number_format($p['total'], 2) ?></td>
                <td><span class="badge badge-<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                <td><?= $p['metodo_entrega'] === 'delivery' ? 'Delivery' : 'Recoger' ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                <td>
                    <a href="/panel/pedidos/<?= $p['id'] ?>" class="btn btn-sm btn-secondary">Ver</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="/panel/pedidos?page=<?= $i ?><?= $estado ? '&estado=' . sanitize($estado) : '' ?>" class="btn btn-sm <?= $i === $page ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>
