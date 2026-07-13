<?php
$titulo = $producto ? 'Editar producto' : 'Nuevo producto';
$imagenes = $imagenes ?? [];
$maxImagenes = 5;
$maxSizeMB = round(UPLOAD_MAX_SIZE / 1048576);
?>

<form method="POST" action="<?= $producto ? '/panel/productos/actualizar/' . $producto['id'] : '/panel/productos/guardar' ?>" enctype="multipart/form-data" class="form-card" id="producto-form">
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
        <label>Imagenes (maximo <?= $maxImagenes ?>, hasta <?= $maxSizeMB ?> MB cada una)</label>

        <?php if (!empty($imagenes)): ?>
        <div class="imagenes-existentes">
            <?php foreach ($imagenes as $img): ?>
            <div class="imagen-existente" id="img-<?= $img['id'] ?>">
                <img src="/uploads/<?= sanitize($img['imagen']) ?>" alt="">
                <button type="button" class="imagen-eliminar-btn" onclick="eliminarImagenExistente(<?= $img['id'] ?>, <?= $producto['id'] ?>)">X</button>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div id="imagenes-preview" class="imagenes-preview"></div>

        <div id="imagenes-error" class="form-error" style="display:none"></div>
        <?php if (!empty($errores['imagenes'])): ?>
        <span class="form-error"><?= sanitize($errores['imagenes']) ?></span>
        <?php endif; ?>
        <?php if (!empty($errores['imagen'])): ?>
        <span class="form-error"><?= sanitize($errores['imagen']) ?></span>
        <?php endif; ?>

        <input type="file" id="imagenes" name="imagenes[]" accept="image/jpeg,image/png,image/webp" multiple style="display:none">
        <button type="button" class="btn btn-secondary btn-sm" id="btn-seleccionar" onclick="document.getElementById('imagenes').click()">Seleccionar imagenes</button>
        <small class="form-help">Formatos: JPG, PNG, WEBP</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $producto ? 'Guardar cambios' : 'Crear producto' ?></button>
        <a href="/panel/productos" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<script>
var maxImagenes = <?= $maxImagenes ?>;
var maxSizeMB = <?= $maxSizeMB ?>;
var maxSizeBytes = maxSizeMB * 1048576;
var imagenesExistentes = <?= count($imagenes) ?>;
var csrfToken = document.querySelector('input[name="_csrf"]').value;

document.getElementById('imagenes').addEventListener('change', function() {
    var archivos = this.files;
    var preview = document.getElementById('imagenes-preview');
    var errorDiv = document.getElementById('imagenes-error');
    preview.innerHTML = '';
    errorDiv.style.display = 'none';

    if (!archivos.length) return;

    var totalDisponible = maxImagenes - imagenesExistentes;
    if (archivos.length > totalDisponible) {
        errorDiv.textContent = 'Solo puedes agregar ' + totalDisponible + ' imagenes mas. Ya tienes ' + imagenesExistentes + ' de ' + maxImagenes + '.';
        errorDiv.style.display = 'block';
        this.value = '';
        return;
    }

    for (var i = 0; i < archivos.length; i++) {
        var archivo = archivos[i];

        if (archivo.size > maxSizeBytes) {
            errorDiv.textContent = 'La imagen "' + archivo.name + '" pesa mas de ' + maxSizeMB + ' MB. Reduce su tamano antes de subirla.';
            errorDiv.style.display = 'block';
            this.value = '';
            preview.innerHTML = '';
            return;
        }

        (function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var div = document.createElement('div');
                div.className = 'imagen-preview-item';
                var img = document.createElement('img');
                img.src = e.target.result;
                var info = document.createElement('span');
                info.className = 'imagen-preview-info';
                info.textContent = file.name + ' (' + (file.size / 1048576).toFixed(1) + ' MB)';
                div.appendChild(img);
                div.appendChild(info);
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        })(archivo);
    }
});

function eliminarImagenExistente(imgId, productoId) {
    if (!confirm('Eliminar esta imagen?')) return;

    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/panel/productos/eliminar-imagen/' + imgId;

    var csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_csrf';
    csrf.value = csrfToken;
    form.appendChild(csrf);

    var pid = document.createElement('input');
    pid.type = 'hidden';
    pid.name = 'producto_id';
    pid.value = productoId;
    form.appendChild(pid);

    document.body.appendChild(form);
    form.submit();
}

document.getElementById('producto-form').addEventListener('submit', function(e) {
    var archivos = document.getElementById('imagenes').files;
    var errorDiv = document.getElementById('imagenes-error');

    if (archivos.length > 0) {
        var totalDisponible = maxImagenes - imagenesExistentes;
        if (archivos.length > totalDisponible) {
            e.preventDefault();
            errorDiv.textContent = 'Solo puedes agregar ' + totalDisponible + ' imagenes mas.';
            errorDiv.style.display = 'block';
            return;
        }

        for (var i = 0; i < archivos.length; i++) {
            if (archivos[i].size > maxSizeBytes) {
                e.preventDefault();
                errorDiv.textContent = 'La imagen "' + archivos[i].name + '" pesa mas de ' + maxSizeMB + ' MB.';
                errorDiv.style.display = 'block';
                return;
            }
        }
    }
});
</script>
