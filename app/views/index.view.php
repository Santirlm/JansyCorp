<!-- HERO -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?= _('Compra con estilo') ?></h1>
            <p class="lead fw-normal text-white-50 mb-4">
                <?= _('Periféricos custom de alto rendimiento para los más exigentes') ?>
            </p>
            <a href="<?= url('productos') ?>" class="btn btn-warning btn-lg fw-bold px-5">
                <?= _('Ver catálogo') ?> <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</header>

<!-- FILTRO + BÚSQUEDA -->
<section class="py-4 bg-light border-bottom">
    <div class="container px-4 px-lg-5">
        <div class="row g-2 align-items-center justify-content-between">
            <div class="col-md-5">
                <form action="<?= url('productos') ?>" method="GET" class="d-flex gap-2">
                    <input type="text" name="buscar" class="form-control"
                           placeholder="<?= _('Buscar producto...') ?>">
                    <button class="btn btn-dark"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="col-md-5">
                <form action="<?= url('productos') ?>" method="GET" class="d-flex gap-2">
                    <select name="categoria" class="form-select">
                        <option value=""><?= _('Todas las categorías') ?></option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat->getId() ?>">
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

<!-- PRODUCTOS DESTACADOS -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">Últimos productos</h2>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errores[0]) ?></div>
        <?php endif; ?>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            <?php if (empty($productos)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-box-seam fs-1"></i>
                    <p class="mt-2">No hay productos disponibles</p>
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
                                </span>
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

        <div class="text-center mt-2">
            <a href="<?= url('productos') ?>" class="btn btn-dark btn-lg">Ver todos los productos</a>
        </div>
    </div>
</section>

<!-- BANNER INFO -->
<section class="py-5 bg-dark text-white">
    <div class="container px-4 px-lg-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <i class="bi bi-truck fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Envío rápido</h6>
                <p class="text-white-50 small">Entrega en 24-48h en toda España</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-check fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Garantía 2 años</h6>
                <p class="text-white-50 small">Todos nuestros productos tienen garantía oficial</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-headset fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Soporte 24/7</h6>
                <p class="text-white-50 small">Equipo técnico especializado a tu disposición</p>
            </div>
        </div>
    </div>
</section>
