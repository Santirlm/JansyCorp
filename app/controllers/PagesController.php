<?php

namespace dwes\app\controllers;

use dwes\app\repository\CategoriaRepository;
use dwes\app\repository\ProductoRepository;
use dwes\core\App;
use dwes\core\Response;

class PagesController
{
    public function index(): void
    {
        $productos  = [];
        $categorias = [];
        $errores    = [];

        try {
            // Ordenados por fecha DESC, máximo 8 en portada
            $todos       = App::getRepository(ProductoRepository::class)->findAllOrdenados();
            $productos   = array_slice($todos, 0, 8);
            $categorias  = App::getRepository(CategoriaRepository::class)->findActivas();
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }

        Response::renderView('index', 'layout', compact('productos', 'categorias', 'errores'));
    }

    public function nosotros(): void
    {
        Response::renderView('nosotros', 'layout');
    }

    public function ubicaciones(): void
    {
        Response::renderView('ubicaciones', 'layout');
    }
}
