<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-2">
            <i class="bi bi-shield-lock-fill me-2 text-warning"></i>Panel de Administración
        </h2>
        <p class="text-muted mb-5">Gestiona los recursos de JansyCorp</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-box-seam fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-bolder">Productos</h5>
                        <p class="text-muted small">Crear, editar y eliminar productos del catálogo</p>
                        <a href="<?= url('admin/productos') ?>" class="btn btn-warning fw-bold w-100">
                            Gestionar productos
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-people-fill fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-bolder">Usuarios</h5>
                        <p class="text-muted small">Gestionar cuentas de usuario y roles</p>
                        <a href="<?= url('admin/usuarios') ?>" class="btn btn-warning fw-bold w-100">
                            Gestionar usuarios
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-graph-up fs-1 text-warning mb-3 d-block"></i>
                        <h5 class="fw-bolder">Resumen</h5>
                        <p class="text-muted small">Bienvenido, <?= htmlspecialchars($app['user']->getNombreCompleto()) ?></p>
                        <a href="<?= url('perfil') ?>" class="btn btn-outline-dark fw-bold w-100">
                            Ver mi perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
