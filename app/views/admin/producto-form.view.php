<?php $editando = isset($producto); ?>
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">
            <i class="bi bi-<?= $editando ? 'pencil-square' : 'plus-circle' ?> me-2 text-warning"></i>
            <?= $editando ? 'Editar producto' : 'Nuevo producto' ?>
        </h2>
        <?php include __DIR__ . '/../partials/show-error.part.php'; ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST"
                              action="<?= $editando
                                  ? url('admin/productos/actualizar/' . $producto->getId())
                                  : url('admin/productos/guardar') ?>"
                              enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required
                                       value="<?= htmlspecialchars($editando ? $producto->getNombre() : ($datos['nombre'] ?? '')) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"><?=
                                    htmlspecialchars($editando ? $producto->getDescripcion() : ($datos['descripcion'] ?? ''))
                                ?></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Precio (€) *</label>
                                    <input type="number" step="0.01" min="0" name="precio"
                                           class="form-control" required
                                           value="<?= $editando ? $producto->getPrecio() : ($datos['precio'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Stock *</label>
                                    <input type="number" min="0" name="stock"
                                           class="form-control" required
                                           value="<?= $editando ? $producto->getStock() : ($datos['stock'] ?? 0) ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Categoría *</label>
                                <select name="categoria_id" class="form-select" required>
                                    <option value="">Selecciona categoría</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat->getId() ?>"
                                            <?= ($editando && $producto->getCategoriaId() == $cat->getId()) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat->getNombre()) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Imagen <?= $editando ? '(vacío = mantener actual)' : '*' ?>
                                </label>
                                <?php if ($editando && $producto->getImagen()): ?>
                                    <div class="mb-2">
                                        <img src="<?= url(htmlspecialchars($producto->getUrlMiniatura())) ?>"
                                             style="height:80px;object-fit:contain;"
                                             onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="imagen" class="form-control"
                                       accept="image/jpeg,image/jpg,image/png,image/gif"
                                       <?= $editando ? '' : 'required' ?>>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning fw-bold px-4">
                                    <i class="bi bi-save me-1"></i>
                                    <?= $editando ? 'Actualizar' : 'Crear producto' ?>
                                </button>
                                <a href="<?= url('admin/productos') ?>" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
