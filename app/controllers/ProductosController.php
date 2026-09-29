<?php

namespace dwes\app\controllers;

use dwes\app\repository\CategoriaRepository;
use dwes\app\repository\ProductoRepository;
use dwes\app\repository\UsuarioRepository;
use dwes\core\App;
use dwes\core\Response;
use dwes\core\helpers\FlashMessage;

class ProductosController
{
    public function index(): void
    {
        $busqueda = trim($_GET['buscar']?? '');
        $categoria_filtro = trim($_GET['categoria'] ?? '');
        $productos = [];
        $categorias = [];
        $errores = FlashMessage::get('productos-error', []);

        try {
            $repo = App::getRepository(ProductoRepository::class);
            $categorias = App::getRepository(CategoriaRepository::class)->findActivas();

            if (!empty($busqueda)) {
                $productos = $repo->buscar($busqueda);
                if (!empty($categoria_filtro)) {
                    $productos = array_filter($productos,
                        fn($p) => $p->getCategoriaId() == $categoria_filtro);
                    $productos = array_values($productos);
                }
            } elseif (!empty($categoria_filtro)) {
                $productos = $repo->findByCategoria((int)$categoria_filtro);
            } else {
                $productos = $repo->findAllOrdenados();
            }
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }

        Response::renderView('productos', 'layout',
            compact('productos', 'categorias', 'busqueda', 'categoria_filtro', 'errores'));
    }

    public function show(string $id): void
    {
        try {
            $producto = App::getRepository(ProductoRepository::class)->find((int)$id);
            $categoria = App::getRepository(CategoriaRepository::class)
                            ->find($producto->getCategoriaId());
            // Autor del producto
            $autor = null;
            if ($producto->getUsuarioId()) {
                try {
                    $autor = App::getRepository(UsuarioRepository::class)
                               ->find($producto->getUsuarioId());
                } catch (\Exception $e) { /* autor eliminado */ }
            }
            Response::renderView('producto', 'layout', compact('producto', 'categoria', 'autor'));
        } catch (\Exception $e) {
            App::get('router')->redirect('productos');
        }
    }
}
