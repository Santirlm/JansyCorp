<section class="py-5">
    <div class="container px-4 px-lg-5">
        <a href="<?= url('productos') ?>" class="btn btn-outline-dark btn-sm mb-4">
            <i class="bi bi-arrow-left me-1"></i>Volver al catálogo
        </a>

        <div class="row g-5 align-items-start">
            <div class="col-md-5 text-center">
                <img src="<?= url(htmlspecialchars($producto->getImagenUrl())) ?>"
                     alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                     class="img-fluid rounded shadow"
                     style="max-height:420px;object-fit:contain;"
                     onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
            </div>

            <div class="col-md-7">
                <?php if ($categoria): ?>
                    <span class="badge bg-secondary mb-2">
                        <?= htmlspecialchars($categoria->getNombre()) ?>
                    </span>
                <?php endif; ?>

                <h1 class="fw-bolder mb-1"><?= htmlspecialchars($producto->getNombre()) ?></h1>
                <div class="fs-3 fw-bold text-warning mb-3">
                    <?= number_format($producto->getPrecio(), 2) ?> €
                </div>
                <p class="lead text-muted mb-4">
                    <?= nl2br(htmlspecialchars($producto->getDescripcion())) ?>
                </p>

                <div class="mb-4">
                    <?php if ($producto->getStock() > 0): ?>
                        <span class="text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i>En stock
                            (<?= $producto->getStock() ?> uds.)
                        </span>
                    <?php else: ?>
                        <span class="text-danger fw-semibold">
                            <i class="bi bi-x-circle-fill me-1"></i>Agotado
                        </span>
                    <?php endif; ?>
                </div>

                <?php if ($producto->getStock() > 0): ?>
                    <?php if (isset($app['user']) && $app['user'] !== null): ?>
                        <a href="<?= url('carrito/add/' . $producto->getId()) ?>"
                           class="btn btn-warning btn-lg fw-bold px-5">
                            <i class="bi bi-cart-plus me-2"></i>Añadir al carrito
                        </a>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="btn btn-dark btn-lg fw-bold px-5">
                            <i class="bi bi-lock me-2"></i>Inicia sesión para comprar
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg" disabled>Agotado</button>
                <?php endif; ?>

                <?php if (isset($autor) && $autor !== null): ?>
                    <div class="mt-5 p-3 bg-light rounded border d-flex align-items-center gap-3">
                        <img src="<?= url('assets/avatares/' . htmlspecialchars($autor->getImgPerfil() ?: 'default-avatar.png')) ?>"
                             class="rounded-circle border border-2 border-warning"
                             style="width:52px;height:52px;object-fit:cover;"
                             onerror="this.src='<?= $baseUrl ?>/assets/avatares/default-avatar.png'">
                        <div class="flex-grow-1">
                            <div class="fw-semibold"><?= htmlspecialchars($autor->getNombreCompleto()) ?></div>
                            <small class="text-muted">
                                Publicado el <?= htmlspecialchars(substr($producto->getFechaAlta(), 0, 10)) ?>
                            </small>
                        </div>
                        <?php if (isset($app['user']) && $app['user'] !== null
                                  && $app['user']->getId() !== $autor->getId()): ?>
                            <a href="#"
                               class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-envelope me-1"></i>Contactar
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
