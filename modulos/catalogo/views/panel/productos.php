<?php $titulo = 'Productos'; ?>

<div class="section-header">
    <h2>Productos (<?= $total ?>)</h2>
    <a href="/panel/productos/crear" class="btn btn-primary">Agregar producto</a>
</div>

<?php if (empty($productos)): ?>
<div class="empty-state">
    <p>Aun no tienes productos.</p>
    <a href="/panel/productos/crear" class="btn btn-primary">Crear tu primer producto</a>
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td>
                    <?php if ($p['imagen']): ?>
                    <img src="/uploads/<?= sanitize($p['imagen']) ?>" alt="" class="thumb">
                    <?php else: ?>
                    <span class="no-image">Sin foto</span>
                    <?php endif; ?>
                </td>
                <td><?= sanitize($p['nombre']) ?></td>
                <td><?= sanitize($p['categoria_nombre'] ?? 'Sin categoria') ?></td>
                <td><?= $user['moneda'] ?? 'C$' ?> <?= number_format($p['precio'], 2) ?></td>
                <td>
                    <form method="POST" action="/panel/productos/disponibilidad/<?= $p['id'] ?>" style="display:inline">
                        <?= csrfField() ?>
                        <button type="submit" class="badge <?= $p['disponible'] ? 'badge-success' : 'badge-muted' ?>">
                            <?= $p['disponible'] ? 'Disponible' : 'No disponible' ?>
                        </button>
                    </form>
                </td>
                <td class="actions">
                    <a href="/panel/productos/editar/<?= $p['id'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="/panel/productos/eliminar/<?= $p['id'] ?>" style="display:inline" onsubmit="return confirm('Eliminar este producto?')">
                        <?= csrfField() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="/panel/productos?page=<?= $i ?>" class="btn btn-sm <?= $i === $page ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>
