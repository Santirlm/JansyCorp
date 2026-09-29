<section class="py-5">
    <div class="container px-4 px-lg-5 text-center">
        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:4rem;"></i>
        <h2 class="fw-bolder mt-3">Algo salió mal</h2>
        <p class="text-muted lead">
            <?= htmlspecialchars($mensaje ?? 'Error desconocido') ?>
        </p>
        <a href="<?= url() ?>" class="btn btn-warning btn-lg fw-bold mt-3">
            <i class="bi bi-house me-2"></i>Volver al inicio
        </a>
    </div>
</section>
