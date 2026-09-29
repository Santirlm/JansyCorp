<?php
// Mostrar mensaje de éxito
$mensaje = $mensaje ?? '';
if (!empty($mensaje)): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <span><?= htmlspecialchars($mensaje) ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Mostrar errores
$errores = $errores ?? [];
if (!empty($errores)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php if (count($errores) === 1): ?>
            <?= htmlspecialchars($errores[0]) ?>
        <?php else: ?>
            <ul class="mb-0 mt-1">
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
