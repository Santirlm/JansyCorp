<?php use dwes\core\helpers\I18n; ?>
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4"><i class="bi bi-person-circle me-2"></i>Mi perfil</h2>

        <?php include __DIR__ . '/partials/show-error.part.php'; ?>

        <div class="row g-4">
            <!-- Tarjeta usuario -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <?php $avatar = $usuario->getImgPerfil() ?: 'default-avatar.png'; ?>
                        <img src="<?= url('assets/avatares/' . htmlspecialchars($avatar)) ?>"
                             alt="Avatar"
                             class="rounded-circle mb-3 border border-3 border-warning"
                             style="width:100px;height:100px;object-fit:cover;"
                             onerror="this.src='<?= $baseUrl ?>/assets/avatares/default-avatar.png'">
                        <h5 class="fw-bolder"><?= htmlspecialchars($usuario->getNombreCompleto()) ?></h5>
                        <p class="text-muted small mb-1">
                            <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($usuario->getEmail()) ?>
                        </p>
                        <p class="text-muted small mb-1">
                            <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($usuario->getTelefono()) ?>
                        </p>
                        <p class="text-muted small">
                            <i class="bi bi-geo-alt me-1"></i>
                            <?= htmlspecialchars($usuario->getDireccion() ?? '-') ?>
                        </p>
                        <span class="badge <?= $usuario->getRol() === 'ROLE_ADMIN' ? 'bg-danger' : 'bg-secondary' ?>">
                            <?= $usuario->getRol() === 'ROLE_ADMIN' ? 'Administrador' : 'Usuario' ?>
                        </span>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <a href="<?= url('logout') ?>" class="btn btn-outline-dark btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formularios -->
            <div class="col-md-8">
                <div class="row g-3">

                    <!-- Cambiar foto -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-dark text-white fw-semibold">
                                <i class="bi bi-camera me-2"></i>Cambiar foto de perfil
                            </div>
                            <div class="card-body">
                                <form action="<?= url('perfil/cambiar-foto') ?>" method="POST"
                                      enctype="multipart/form-data">
                                    <div class="input-group">
                                        <input type="file" name="foto" class="form-control"
                                               accept="image/jpeg,image/jpg,image/png" required>
                                        <button type="submit" class="btn btn-warning fw-bold">
                                            Actualizar foto
                                        </button>
                                    </div>
                                    <small class="text-muted">JPG o PNG. Recomendado: 200×200px</small>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cambiar contraseña -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-dark text-white fw-semibold">
                                <i class="bi bi-key me-2"></i>Cambiar contraseña
                            </div>
                            <div class="card-body">
                                <form action="<?= url('perfil/cambiar-password') ?>" method="POST">
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold small">Contraseña actual</label>
                                        <input type="password" name="password_actual"
                                               class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold small">Nueva contraseña</label>
                                        <input type="password" name="password_nueva"
                                               class="form-control form-control-sm"
                                               placeholder="Mín. 6 caracteres" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Confirmar nueva contraseña</label>
                                        <input type="password" name="password_confirma"
                                               class="form-control form-control-sm" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-sm fw-bold">
                                        Actualizar contraseña
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cambiar idioma -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-dark text-white fw-semibold">
                                <i class="bi bi-translate me-2"></i>Idioma de la interfaz
                            </div>
                            <div class="card-body">
                                <form action="<?= url('perfil/idioma') ?>" method="POST"
                                      class="d-flex align-items-center gap-3">
                                    <select name="lang" class="form-select form-select-sm" style="max-width:200px;">
                                        <option value="es" <?= $usuario->getIdioma() === 'es_ES' ? 'selected' : '' ?>>
                                            🇪🇸 Español
                                        </option>
                                        <option value="en" <?= $usuario->getIdioma() === 'en_GB' ? 'selected' : '' ?>>
                                            🇬🇧 English
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-sm fw-bold">
                                        Guardar idioma
                                    </button>
                                </form>
                                <small class="text-muted mt-1 d-block">
                                    Idioma actual: <strong><?= $usuario->getIdioma() === 'en_GB' ? 'English' : 'Español' ?></strong>
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Historial de pedidos -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white fw-semibold">
                        <i class="bi bi-bag-heart me-2"></i>Mis pedidos
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($pedidos)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-bag-x fs-2 d-block mb-2"></i>
                                Aún no has realizado ningún pedido.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th><th>Fecha</th><th>Productos</th>
                                            <th class="text-end">Total</th><th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido): ?>
                                            <tr>
                                                <td><strong>#<?= $pedido->getId() ?></strong></td>
                                                <td><?= htmlspecialchars(substr($pedido->getFecha(), 0, 10)) ?></td>
                                                <td>
                                                    <?php foreach ($lineasPorPedido[$pedido->getId()] as $det): ?>
                                                        <div class="small">
                                                            <?php if ($det['producto']): ?>
                                                                <?= htmlspecialchars($det['producto']->getNombre()) ?>
                                                                x<?= $det['linea']->getCantidad() ?>
                                                            <?php else: ?>
                                                                <span class="text-muted">Producto eliminado</span>
                                                                x<?= $det['linea']->getCantidad() ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td class="text-end fw-bold text-warning">
                                                    <?= number_format($pedido->getTotal(), 2) ?> €
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        <?= ucfirst($pedido->getEstado()) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
