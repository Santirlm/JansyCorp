<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0 fw-bolder">
                            <i class="bi bi-person-lock me-2"></i><?= _('Iniciar sesión') ?>
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php include __DIR__ . '/partials/show-error.part.php'; ?>
                        <form action="<?= url('check-login') ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold"><?= _('Email') ?></label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="tu@email.com"
                                       value="<?= htmlspecialchars($email ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"><?= _('Contraseña') ?></label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="••••••••" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <?= _('Iniciar sesión') ?> <i class="bi bi-arrow-right-circle ms-1"></i>
                                </button>
                            </div>
                        </form>
                        <hr>
                        <p class="text-center mb-0 small">
                            ¿No tienes cuenta?
                            <a href="<?= url('registro') ?>" class="fw-bold"><?= _('Registrarse') ?></a>
                        </p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= url() ?>" class="text-muted small">
                        <i class="bi bi-arrow-left me-1"></i>Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
