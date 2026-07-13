<div class="auth-container">
    <div class="auth-card">
        <h2>Iniciar sesion</h2>

        <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <?= csrfField() ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= sanitize($email ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Contrasena</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>

        <p class="auth-link">No tienes cuenta? <a href="/registro">Registrate aqui</a></p>
    </div>
</div>
