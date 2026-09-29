<?php use dwes\core\App; ?>
<section class="py-5">
    <div class="container px-4 px-lg-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bolder mb-0">
                <i class="bi bi-people-fill me-2 text-warning"></i>Gestionar Usuarios
            </h2>
            <a href="<?= url('admin') ?>" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver al panel
            </a>
        </div>

        <?php include __DIR__ . '/../partials/show-error.part.php'; ?>

        <!-- Filtro por rol -->
        <form action="<?= url('admin/usuarios') ?>" method="GET"
              class="d-flex align-items-center gap-2 mb-4" style="max-width:320px;">
            <select name="rol" class="form-select form-select-sm">
                <option value="">Todos los roles</option>
                <option value="ROLE_USER"  <?= ($filtroRol ?? '') === 'ROLE_USER'  ? 'selected' : '' ?>>Usuario</option>
                <option value="ROLE_ADMIN" <?= ($filtroRol ?? '') === 'ROLE_ADMIN' ? 'selected' : '' ?>>Administrador</option>
            </select>
            <button class="btn btn-dark btn-sm px-3">Filtrar</button>
            <?php if (!empty($filtroRol)): ?>
                <a href="<?= url('admin/usuarios') ?>" class="btn btn-outline-secondary btn-sm">✕</a>
            <?php endif; ?>
        </form>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="8%">Avatar</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th width="10%">Teléfono</th>
                                <th width="10%">Rol</th>
                                <th width="10%">Alta</th>
                                <th width="18%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="bi bi-people fs-2 d-block mb-2"></i>
                                        No hay usuarios con ese filtro.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u):
                                    $esYo = $u->getId() === App::get('appUser')->getId(); ?>
                                <tr class="<?= $esYo ? 'table-warning' : '' ?>">
                                    <td class="text-muted small"><?= $u->getId() ?></td>
                                    <td>
                                        <img src="<?= url('assets/avatares/' . htmlspecialchars($u->getImgPerfil() ?: 'default-avatar.png')) ?>"
                                             class="rounded-circle border"
                                             style="width:38px;height:38px;object-fit:cover;"
                                             onerror="this.src='<?= $baseUrl ?>/assets/avatares/default-avatar.png'">
                                    </td>
                                    <td>
                                        <span class="fw-semibold"><?= htmlspecialchars($u->getNombreCompleto()) ?></span>
                                        <?php if ($esYo): ?>
                                            <span class="badge bg-info text-dark ms-1 small">Tú</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted"><?= htmlspecialchars($u->getEmail()) ?></td>
                                    <td class="small"><?= htmlspecialchars($u->getTelefono()) ?></td>
                                    <td>
                                        <span class="badge <?= $u->getRol() === 'ROLE_ADMIN' ? 'bg-danger' : 'bg-secondary' ?>">
                                            <?= $u->getRol() === 'ROLE_ADMIN' ? 'Admin' : 'Usuario' ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <?= htmlspecialchars(substr($u->getFechaAlta(), 0, 10)) ?>
                                    </td>
                                    <td>
                                        <?php if (!$esYo): ?>
                                            <form action="<?= url('admin/usuarios/rol/' . $u->getId()) ?>"
                                                  method="POST" class="d-flex gap-1 align-items-center mb-1">
                                                <select name="rol" class="form-select form-select-sm" style="width:110px;">
                                                    <option value="ROLE_USER"  <?= $u->getRol() === 'ROLE_USER'  ? 'selected':'' ?>>Usuario</option>
                                                    <option value="ROLE_ADMIN" <?= $u->getRol() === 'ROLE_ADMIN' ? 'selected':'' ?>>Admin</option>
                                                </select>
                                                <button type="submit" class="btn btn-outline-warning btn-sm" title="Cambiar rol">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                            <a href="<?= url('admin/usuarios/eliminar/' . $u->getId()) ?>"
                                               class="btn btn-outline-danger btn-sm w-100"
                                               onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">
                                                <i class="bi bi-trash me-1"></i>Eliminar
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted small bg-light">
                Total: <strong><?= count($usuarios) ?></strong> usuario(s)
            </div>
        </div>

    </div>
</section>
