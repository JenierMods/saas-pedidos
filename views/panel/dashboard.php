<?php $titulo = 'Dashboard'; ?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-numero"><?= $stats['productos'] ?></span>
        <span class="stat-label">Productos</span>
    </div>
    <div class="stat-card">
        <span class="stat-numero"><?= $stats['pedidos_hoy'] ?></span>
        <span class="stat-label">Pedidos hoy</span>
    </div>
    <div class="stat-card">
        <span class="stat-numero"><?= sanitize($user['moneda'] ?? 'C$') ?> <?= number_format($stats['ventas_hoy'], 2) ?></span>
        <span class="stat-label">Ventas hoy</span>
    </div>
    <div class="stat-card">
        <span class="stat-numero"><?= $stats['pedidos_nuevos'] ?></span>
        <span class="stat-label">Pedidos nuevos</span>
    </div>
</div>

<div class="dashboard-section">
    <h3>Tu tienda en linea</h3>
    <div class="tienda-link-box">
        <input type="text" id="tienda-url" value="<?= url('/tienda/' . sanitize($user['slug'] ?? '')) ?>" readonly>
        <button class="btn btn-secondary" onclick="copiarEnlace()">Copiar enlace</button>
    </div>
    <p class="text-muted">Comparte este enlace con tus clientes para que vean tu catalogo y hagan pedidos.</p>
</div>
