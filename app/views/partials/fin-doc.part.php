<footer class="py-5 bg-dark text-white">
    <div class="container px-4 px-lg-5">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bolder text-warning">
                    <i class="bi bi-cpu-fill me-2"></i>JansyCorp
                </h5>
                <p class="text-white-50 small mt-2">
                    Tu tienda de periféricos custom de alto rendimiento.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h6 class="fw-bolder">Navegación</h6>
                <ul class="list-unstyled mt-2">
                    <li><a href="<?= url() ?>" class="footer-link">Inicio</a></li>
                    <li><a href="<?= url('productos') ?>" class="footer-link">Productos</a></li>
                    <li><a href="<?= url('nosotros') ?>" class="footer-link">Nosotros</a></li>
                    <li><a href="<?= url('ubicaciones') ?>" class="footer-link">Ubicaciones</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bolder">Contacto</h6>
                <ul class="list-unstyled mt-2 text-white-50 small">
                    <li><i class="bi bi-envelope me-2"></i>info@jansycorp.com</li>
                    <li><i class="bi bi-telephone me-2"></i>+34 900 000 000</li>
                    <li><i class="bi bi-geo-alt me-2"></i>Calle Mayor 1, Madrid</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center text-white-50 small">
            &copy; <?= date('Y') ?> JansyCorp — Todos los derechos reservados
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
