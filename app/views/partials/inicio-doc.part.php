<?php use dwes\core\helpers\I18n; ?>
<!DOCTYPE html>
<html lang="<?= substr(I18n::getActivo(), 0, 2) ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JansyCorp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?= url('css/styles.css') ?>" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bolder" href="<?= url() ?>">
            <i class="bi bi-cpu-fill me-2 text-warning"></i>JansyCorp
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="<?= url() ?>"><?= _('Inicio') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('productos') ?>"><?= _('Productos') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('nosotros') ?>"><?= _('Nosotros') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('ubicaciones') ?>"><?= _('Ubicaciones') ?></a></li>

                <?php if (isset($app['user']) && $app['user'] !== null && $app['user']->getRol() === 'ROLE_ADMIN'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#"
                           id="adminDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-lock-fill me-1"></i>Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="<?= url('admin/productos') ?>">
                                    <i class="bi bi-box-seam me-2"></i>Gestionar Productos
                                </a></li>
                            <li><a class="dropdown-item" href="<?= url('admin/usuarios') ?>">
                                    <i class="bi bi-people-fill me-2"></i>Gestionar Usuarios
                                </a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <?php if (isset($app['user']) && $app['user'] !== null): ?>
                    <a href="<?= url('carrito') ?>" class="btn btn-outline-light btn-sm position-relative">
                        <i class="bi bi-cart-fill"></i>
                        <?php $numCarrito = count($_SESSION['carrito'] ?? []); ?>
                        <?php if ($numCarrito > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark"
                                  style="font-size:.65rem;"><?= $numCarrito ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                            <img src="<?= url('assets/avatares/' . htmlspecialchars($app['user']->getImgPerfil() ?: 'default-avatar.png')) ?>"
                                 class="rounded-circle me-1"
                                 style="width:22px;height:22px;object-fit:cover;"
                                 onerror="this.onerror=null;this.src='<?= $baseUrl ?>/assets/avatares/default-avatar.png'">
                            <?= htmlspecialchars($app['user']->getNombre()) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?= url('perfil') ?>">
                                    <i class="bi bi-person-circle me-2"></i>Mi perfil
                                </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                </a></li>
                        </ul>
                    </div>

                <?php else: ?>
                    <form action="" method="GET" class="d-flex align-items-center gap-1 me-1">
                        <select name="lang" class="form-select form-select-sm bg-dark text-white border-secondary"
                                style="width:auto;" onchange="this.form.submit()">
                            <option value="es" <?= I18n::getActivo() === 'es_ES' ? 'selected' : '' ?>>🇪🇸 ES</option>
                            <option value="en" <?= I18n::getActivo() === 'en_GB' ? 'selected' : '' ?>>🇬🇧 EN</option>
                        </select>
                    </form>
                    <a href="<?= url('login') ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-person me-1"></i><?= _('Iniciar sesión') ?>
                    </a>
                    <a href="<?= url('carrito') ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-cart-fill"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>