<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bolder mb-0">
                <i class="bi bi-box-seam me-2 text-warning"></i>Gestionar Productos
            </h2>
            <a href="<?= url('admin/productos/crear') ?>" class="btn btn-warning fw-bold">
                <i class="bi bi-plus-circle me-1"></i>Nuevo producto
            </a>
        </div>

        <?php include __DIR__ . '/../partials/show-error.part.php'; ?>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="8%">Imagen</th>
                            <th>Nombre</th>
                            <th width="10%">Precio</th>
                            <th width="8%">Stock</th>
                            <th width="12%">Categoría</th>
                            <th width="10%">Alta</th>
                            <th width="12%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($productos)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td class="text-muted small"><?= $p->getId() ?></td>
                                    <td>
                                        <img src="<?= url(htmlspecialchars($p->getUrlMiniatura())) ?>"
                                             style="width:48px;height:48px;object-fit:contain;"
                                             onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
                                    </td>
                                    <td class="fw-semibold"><?= htmlspecialchars($p->getNombre()) ?></td>
                                    <td><?= number_format($p->getPrecio(), 2) ?> €</td>
                                    <td>
                                        <span class="badge <?= $p->getStock() > 0 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $p->getStock() ?> uds
                                        </span>
                                    </td>
                                    <td class="small">
                                        <?php
                                        $catNombre = '-';
                                        foreach ($categorias as $cat) {
                                            if ($cat->getId() == $p->getCategoriaId()) {
                                                $catNombre = $cat->getNombre(); break;
                                            }
                                        }
                                        echo htmlspecialchars($catNombre);
                                        ?>
                                    </td>
                                    <td class="small text-muted">
                                        <?= htmlspecialchars(substr($p->getFechaAlta(), 0, 10)) ?>
                                    </td>
                                    <td>
                                        <a href="<?= url('admin/productos/editar/' . $p->getId()) ?>"
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= url('admin/productos/eliminar/' . $p->getId()) ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('¿Eliminar este producto?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-muted small">
                Total: <strong><?= count($productos) ?></strong> producto(s)
            </div>
        </div>
        <div class="mt-3">
            <a href="<?= url('admin') ?>" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver al panel
            </a>
        </div>
    </div>
</section>
