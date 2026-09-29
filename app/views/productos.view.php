<header class="bg-dark py-4">
    <div class="container px-4 px-lg-5 my-3 text-center text-white">
        <h1 class="display-5 fw-bolder"><?= _('Productos') ?></h1>
        <p class="lead text-white-50">Encuentra el periférico perfecto para ti</p>
    </div>
</header>

<section class="py-4 bg-light border-bottom">
    <div class="container px-4 px-lg-5">
        <div class="row g-2 align-items-center justify-content-between">
            <div class="col-md-5">
                <form action="<?= url('productos') ?>" method="GET" class="d-flex gap-2">
                    <?php if (!empty($categoria_filtro)): ?>
                        <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria_filtro) ?>">
                    <?php endif; ?>
                    <input type="text" name="buscar" class="form-control"
                           placeholder="<?= _('Buscar producto...') ?>"
                           value="<?= htmlspecialchars($busqueda) ?>">
                    <button class="btn btn-dark"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="col-md-5">
                <form action="<?= url('productos') ?>" method="GET" class="d-flex gap-2">
                    <?php if (!empty($busqueda)): ?>
                        <input type="hidden" name="buscar" value="<?= htmlspecialchars($busqueda) ?>">
                    <?php endif; ?>
                    <select name="categoria" class="form-select">
                        <option value=""><?= _('Todas las categorías') ?></option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat->getId() ?>"
                                <?= $categoria_filtro == $cat->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->getNombre()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-dark">Filtrar</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <?php include __DIR__ . '/partials/show-error.part.php'; ?>

        <?php if (!empty($busqueda)): ?>
            <p class="text-muted mb-4">
                Resultados para: <strong>"<?= htmlspecialchars($busqueda) ?>"</strong>
                &mdash; <a href="<?= url('productos') ?>">Limpiar</a>
            </p>
        <?php endif; ?>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            <?php if (empty($productos)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-box-seam fs-1"></i>
                    <p class="mt-2">No se encontraron productos</p>
                    <a href="<?= url('productos') ?>" class="btn btn-outline-dark btn-sm mt-1">Ver todo</a>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                    <div class="col mb-5">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="product-img-wrap">
                                <img class="card-img-top"
                                     src="<?= url(htmlspecialchars($p->getUrlMiniatura())) ?>"
                                     alt="<?= htmlspecialchars($p->getNombre()) ?>"
                                     onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
                            </div>
                            <div class="card-body p-4 text-center">
                                <h6 class="fw-bolder"><?= htmlspecialchars($p->getNombre()) ?></h6>
                                <span class="fw-bold text-warning fs-5">
                                    <?= number_format($p->getPrecio(), 2) ?> €
                                </span><br>
                                <small class="text-muted">
                                    <?php if ($p->getStock() > 0): ?>
                                        Stock: <?= $p->getStock() ?> uds.
                                    <?php else: ?>
                                        <span class="text-danger">Agotado</span>
                                    <?php endif; ?>
                                </small>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4 pt-0 text-center">
                                <a href="<?= url('productos/' . $p->getId()) ?>"
                                   class="btn btn-outline-dark btn-sm w-100 mb-2">
                                    <?= _('Ver detalles') ?>
                                </a>
                                <?php if ($p->getStock() > 0): ?>
                                    <?php if (isset($app['user']) && $app['user'] !== null): ?>
                                        <a href="<?= url('carrito/add/' . $p->getId()) ?>"
                                           class="btn btn-warning btn-sm w-100">
                                            <i class="bi bi-cart-plus me-1"></i><?= _('Añadir al carrito') ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= url('login') ?>"
                                           class="btn btn-outline-secondary btn-sm w-100">
                                            <i class="bi bi-lock me-1"></i><?= _('Login para comprar') ?>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <?= _('Agotado') ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
