<?php $titulo = 'Categorias'; ?>

<div class="section-header">
    <h2>Categorias</h2>
</div>

<form method="POST" action="/panel/categorias/guardar" class="inline-form">
    <?= csrfField() ?>
    <input type="text" name="nombre" placeholder="Nombre de la categoria" required>
    <button type="submit" class="btn btn-primary">Agregar</button>
</form>

<?php if (empty($categorias)): ?>
<div class="empty-state">
    <p>No tienes categorias. Crea una para organizar tus productos.</p>
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $cat): ?>
            <tr>
                <td><?= sanitize($cat['nombre']) ?></td>
                <td>
                    <form method="POST" action="/panel/categorias/eliminar/<?= $cat['id'] ?>" style="display:inline" onsubmit="return confirm('Eliminar esta categoria?')">
                        <?= csrfField() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
