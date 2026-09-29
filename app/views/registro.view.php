<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0 fw-bolder">
                            <i class="bi bi-person-plus me-2"></i><?= _('Crear cuenta') ?>
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php include __DIR__ . '/partials/show-error.part.php'; ?>
                        <form action="<?= url('check-registro') ?>" method="POST">
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><?= _('Nombre') ?> *</label>
                                    <input type="text" name="nombre" class="form-control"
                                           value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><?= _('Apellido') ?> *</label>
                                    <input type="text" name="apellido" class="form-control"
                                           value="<?= htmlspecialchars($datos['apellido'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold"><?= _('Email') ?> *</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= htmlspecialchars($datos['email'] ?? '') ?>" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold"><?= _('Teléfono') ?> *</label>
                                <input type="tel" name="telefono" class="form-control"
                                       value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold"><?= _('Dirección') ?> *</label>
                                <input type="text" name="direccion" class="form-control"
                                       value="<?= htmlspecialchars($datos['direccion'] ?? '') ?>" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold"><?= _('Contraseña') ?> *</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Mín. 6 caracteres" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"><?= _('Confirmar contraseña') ?> *</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>

                            <!-- CAPTCHA -->
                            <div class="mb-3 border rounded p-3 bg-light">
                                <label class="form-label fw-semibold">
                                    <?= _('Código de verificación') ?> *
                                </label>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="<?= url('captcha.php') ?>?codigo=<?= htmlspecialchars($captchaCodigo) ?>"
                                         alt="Captcha"
                                         class="border rounded"
                                         style="max-width:100%;">
                                    <a href="<?= url('registro') ?>" class="btn btn-outline-secondary btn-sm"
                                       title="Regenerar código">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                                <input type="text" name="captcha_user" class="form-control"
                                       placeholder="<?= _('Introduce el código de la imagen') ?>"
                                       autocomplete="off" required>
                                <input type="hidden" name="captcha_oculto"
                                       value="<?= htmlspecialchars($captchaCodigo) ?>">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <?= _('Registrarse') ?> <i class="bi bi-check-circle ms-1"></i>
                                </button>
                            </div>
                        </form>
                        <hr>
                        <p class="text-center mb-0 small">
                            ¿Ya tienes cuenta?
                            <a href="<?= url('login') ?>" class="fw-bold"><?= _('Iniciar sesión') ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
