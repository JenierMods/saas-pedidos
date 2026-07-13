<?php $titulo = $producto ? 'Editar producto' : 'Nuevo producto'; ?>

<form method="POST" action="<?= $producto ? '/panel/productos/actualizar/' . $producto['id'] : '/panel/productos/guardar' ?>" enctype="multipart/form-data" class="form-card">
    <?= csrfField() ?>

    <div class="form-group">
        <label for="nombre">Nombre del producto</label>
        <input type="text" id="nombre" name="nombre" value="<?= sanitize($old['nombre'] ?? $producto['nombre'] ?? '') ?>" required>
        <?php if (!empty($errores['nombre'])): ?>
        <span class="form-error"><?= sanitize($errores['nombre']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?= sanitize($old['precio'] ?? $producto['precio'] ?? '') ?>" required>
        <?php if (!empty($errores['precio'])): ?>
        <span class="form-error"><?= sanitize($errores['precio']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoria</label>
        <select id="categoria_id" name="categoria_id">
            <option value="">Sin categoria</option>
            <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($old['categoria_id'] ?? $producto['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                <?= sanitize($cat['nombre']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion" rows="3"><?= sanitize($old['descripcion'] ?? $producto['descripcion'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="imagen">Imagen</label>
        <?php if (!empty($producto['imagen'])): ?>
        <div class="current-image">
            <img src="/uploads/<?= sanitize($producto['imagen']) ?>" alt="" style="max-width:200px">
        </div>
        <?php endif; ?>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
        <?php if (!empty($errores['imagen'])): ?>
        <span class="form-error"><?= sanitize($errores['imagen']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $producto ? 'Guardar cambios' : 'Crear producto' ?></button>
        <a href="/panel/productos" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
