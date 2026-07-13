<?php $titulo = 'Ajustes del negocio'; ?>

<form method="POST" action="/panel/config" enctype="multipart/form-data" class="form-card">
    <?= csrfField() ?>

    <div class="form-group">
        <label for="nombre">Nombre del negocio</label>
        <input type="text" id="nombre" name="nombre" value="<?= sanitize($negocio['nombre'] ?? '') ?>" required>
        <?php if (!empty($errores['nombre'])): ?>
        <span class="form-error"><?= sanitize($errores['nombre']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="telefono">Telefono (WhatsApp)</label>
        <input type="tel" id="telefono" name="telefono" value="<?= sanitize($negocio['telefono'] ?? '') ?>" required>
        <?php if (!empty($errores['telefono'])): ?>
        <span class="form-error"><?= sanitize($errores['telefono']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="moneda">Moneda</label>
        <select id="moneda" name="moneda">
            <option value="C$" <?= ($negocio['moneda'] ?? '') === 'C$' ? 'selected' : '' ?>>C$ (Cordobas)</option>
            <option value="$" <?= ($negocio['moneda'] ?? '') === '$' ? 'selected' : '' ?>>$ (Dolares)</option>
            <option value="L" <?= ($negocio['moneda'] ?? '') === 'L' ? 'selected' : '' ?>>L (Lempiras)</option>
            <option value="Q" <?= ($negocio['moneda'] ?? '') === 'Q' ? 'selected' : '' ?>>Q (Quetzales)</option>
        </select>
    </div>

    <div class="form-group">
        <label for="horario">Horario de atencion</label>
        <input type="text" id="horario" name="horario" value="<?= sanitize($negocio['horario'] ?? '') ?>" placeholder="Ej: Lun-Sab 8am-6pm">
    </div>

    <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" id="direccion" name="direccion" value="<?= sanitize($negocio['direccion'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="logo">Logo</label>
        <?php if (!empty($negocio['logo'])): ?>
        <div class="current-image">
            <img src="/uploads/<?= sanitize($negocio['logo']) ?>" alt="Logo actual" style="max-width:120px">
        </div>
        <?php endif; ?>
        <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp">
        <?php if (!empty($errores['logo'])): ?>
        <span class="form-error"><?= sanitize($errores['logo']) ?></span>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>
