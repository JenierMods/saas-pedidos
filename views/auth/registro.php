<div class="auth-container">
    <div class="auth-card">
        <h2>Crear cuenta</h2>

        <?php if (!empty($errores['general'])): ?>
        <div class="alert alert-error"><?= sanitize($errores['general']) ?></div>
        <?php endif; ?>

        <form method="POST" action="/registro">
            <?= csrfField() ?>
            <div class="form-group">
                <label for="nombre_negocio">Nombre de tu negocio</label>
                <input type="text" id="nombre_negocio" name="nombre_negocio" value="<?= sanitize($old['nombre_negocio'] ?? '') ?>" required>
                <?php if (!empty($errores['nombre_negocio'])): ?>
                <span class="form-error"><?= sanitize($errores['nombre_negocio']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="nombre">Tu nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= sanitize($old['nombre'] ?? '') ?>" required>
                <?php if (!empty($errores['nombre'])): ?>
                <span class="form-error"><?= sanitize($errores['nombre']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= sanitize($old['email'] ?? '') ?>" required>
                <?php if (!empty($errores['email'])): ?>
                <span class="form-error"><?= sanitize($errores['email']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono (WhatsApp)</label>
                <input type="tel" id="telefono" name="telefono" value="<?= sanitize($old['telefono'] ?? '') ?>" required>
                <?php if (!empty($errores['telefono'])): ?>
                <span class="form-error"><?= sanitize($errores['telefono']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Contrasena</label>
                <input type="password" id="password" name="password" required minlength="6">
                <?php if (!empty($errores['password'])): ?>
                <span class="form-error"><?= sanitize($errores['password']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmar contrasena</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
                <?php if (!empty($errores['password_confirm'])): ?>
                <span class="form-error"><?= sanitize($errores['password_confirm']) ?></span>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Crear mi cuenta</button>
        </form>

        <p class="auth-link">Ya tienes cuenta? <a href="/login">Inicia sesion</a></p>
    </div>
</div>
