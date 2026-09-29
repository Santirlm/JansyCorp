<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">
            <i class="bi bi-cart3 me-2"></i><?= _('Tu carrito') ?>
        </h2>

        <?php include __DIR__ . '/partials/show-error.part.php'; ?>

        <?php if (empty($productos)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                <p class="lead"><?= _('Tu carrito está vacío') ?></p>
                <a href="<?= url('productos') ?>" class="btn btn-warning fw-bold mt-2">
                    <i class="bi bi-shop me-1"></i><?= _('Explorar productos') ?>
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <?php foreach ($productos as $item): ?>
                                <?php $p = $item['producto']; $cant = $item['cantidad']; ?>
                                <div class="d-flex align-items-center border-bottom p-3 gap-3">
                                    <img src="<?= url(htmlspecialchars($p->getUrlMiniatura())) ?>"
                                         alt="<?= htmlspecialchars($p->getNombre()) ?>"
                                         style="width:80px;height:80px;object-fit:contain;"
                                         onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bolder"><?= htmlspecialchars($p->getNombre()) ?></h6>
                                        <small class="text-muted">
                                            <?= number_format($p->getPrecio(), 2) ?> € × <?= $cant ?> uds.
                                        </small>
                                    </div>
                                    <div class="fw-bold text-warning fs-5 me-3">
                                        <?= number_format($p->getPrecio() * $cant, 2) ?> €
                                    </div>
                                    <a href="<?= url('carrito/remove/' . $p->getId()) ?>"
                                       class="btn btn-outline-danger btn-sm" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer bg-transparent text-end">
                            <a href="<?= url('carrito/vaciar') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle me-1"></i><?= _('Vaciar carrito') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white fw-bolder">
                            <?= _('Resumen del pedido') ?>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= _('Subtotal') ?></span>
                                <span><?= number_format($total, 2) ?> €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted small">
                                <span><?= _('Envío') ?></span>
                                <span><?= _('Gratis') ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span><?= _('Total') ?></span>
                                <span class="text-warning"><?= number_format($total, 2) ?> €</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <form action="<?= url('carrito/comprar') ?>" method="POST">
                                <button type="submit" class="btn btn-warning w-100 fw-bold">
                                    <i class="bi bi-bag-check me-1"></i><?= _('Finalizar compra') ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
