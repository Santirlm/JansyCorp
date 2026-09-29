<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Sobre JansyCorp</h1>
            <p class="lead fw-normal text-white-50 mb-0">Pasión, precisión y personalización</p>
        </div>
    </div>
</header>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-md-5 text-center mb-4 mb-md-0">
                <img src="<?= url('assets/logo.jpg') ?>" alt="JansyCorp"
                     class="img-fluid rounded shadow"
                     onerror="this.src='<?= $baseUrl ?>/assets/no-image.png'">
            </div>
            <div class="col-md-7">
                <h2 class="fw-bolder mb-3">Innovación en cada detalle</h2>
                <p class="lead text-muted">
                    En JansyCorp creemos que los periféricos no son solo herramientas,
                    sino una extensión de tu personalidad y tu forma de trabajar.
                </p>
                <p class="text-muted">
                    Fundada en 2023, nuestra misión es ofrecer periféricos custom de alto nivel:
                    teclados mecánicos, ratones de precisión, mesas de audio y mucho más, difíciles
                    de encontrar en las tiendas convencionales. Todo curado y seleccionado por personas
                    que realmente entienden de hardware.
                </p>
                <p class="text-muted">
                    También disponemos de los componentes más habituales (tarjetas gráficas, memorias,
                    fuentes de alimentación...) para que encuentres todo lo que necesitas en un solo lugar.
                </p>
                <a href="<?= url('productos') ?>" class="btn btn-warning fw-bold mt-2">
                    <i class="bi bi-shop me-1"></i>Ver nuestros productos
                </a>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 text-center">
        <h3 class="fw-bolder mb-4">¿Por qué elegirnos?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <i class="bi bi-gem fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Productos de nicho</h6>
                <p class="text-muted small">Artículos únicos que no encontrarás en cualquier tienda</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-people fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Comunidad apasionada</h6>
                <p class="text-muted small">Equipo formado por entusiastas del hardware</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-award fs-2 text-warning mb-2 d-block"></i>
                <h6 class="fw-bolder">Calidad garantizada</h6>
                <p class="text-muted small">Solo trabajamos con marcas y fabricantes de confianza</p>
            </div>
        </div>
    </div>
</section>