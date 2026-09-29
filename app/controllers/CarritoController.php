<?php

namespace dwes\app\controllers;

use dwes\app\entity\LineaPedido;
use dwes\app\entity\Pedido;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\PedidoRepository;
use dwes\app\repository\ProductoRepository;
use dwes\core\App;
use dwes\core\Response;
use dwes\core\helpers\FlashMessage;

class CarritoController
{
    /* =========================================================
     *  Ver carrito
     * ========================================================= */
    public function index(): void
    {
        $carrito   = $_SESSION['carrito'] ?? [];
        $productos = [];
        $total     = 0.0;
        $errores   = FlashMessage::get('carrito-error', []);
        $mensaje   = FlashMessage::get('carrito-mensaje', '');

        if (!empty($carrito)) {
            $repo = App::getRepository(ProductoRepository::class);
            foreach ($carrito as $id => $cantidad) {
                try {
                    $p = $repo->find((int)$id);
                    $productos[] = ['producto' => $p, 'cantidad' => $cantidad];
                    $total += $p->getPrecio() * $cantidad;
                } catch (\Exception $e) {
                    // producto ya no existe, lo quitamos
                    unset($_SESSION['carrito'][$id]);
                }
            }
        }

        Response::renderView('carrito', 'layout', compact('productos', 'total', 'errores', 'mensaje'));
    }

    /* =========================================================
     *  Añadir al carrito (requiere login)
     * ========================================================= */
    public function add(string $id): void
    {
        $productoId = (int)$id;

        // Verificar que el producto existe
        try {
            App::getRepository(ProductoRepository::class)->find($productoId);
        } catch (\Exception $e) {
            App::get('router')->redirect('productos');
            return;
        }

        if (!isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId] = 1;
        } else {
            $_SESSION['carrito'][$productoId]++;
        }

        FlashMessage::set('carrito-mensaje', 'Producto añadido al carrito correctamente.');
        App::get('router')->redirect('carrito');
    }

    /* =========================================================
     *  Eliminar línea del carrito
     * ========================================================= */
    public function remove(string $id): void
    {
        unset($_SESSION['carrito'][(int)$id]);
        FlashMessage::set('carrito-mensaje', 'Producto eliminado del carrito.');
        App::get('router')->redirect('carrito');
    }

    /* =========================================================
     *  Vaciar carrito
     * ========================================================= */
    public function vaciar(): void
    {
        $_SESSION['carrito'] = [];
        App::get('router')->redirect('carrito');
    }

    /* =========================================================
     *  Finalizar compra
     * ========================================================= */
    public function comprar(): void
    {
        try {
            $carrito = $_SESSION['carrito'] ?? [];

            if (empty($carrito)) {
                FlashMessage::set('carrito-error', ['El carrito está vacío']);
                App::get('router')->redirect('carrito');
                return;
            }

            $usuario = App::get('appUser');
            $repo    = App::getRepository(ProductoRepository::class);
            $lineas  = [];
            $total   = 0.0;

            foreach ($carrito as $productoId => $cantidad) {
                $producto = $repo->find((int)$productoId);

                if ($producto->getStock() < $cantidad)
                    throw new \Exception("Stock insuficiente para: " . $producto->getNombre());

                $linea = new LineaPedido();
                $linea->setProductoId((int)$productoId)
                      ->setCantidad($cantidad)
                      ->setPrecioUnit($producto->getPrecio());

                $lineas[] = $linea;
                $total   += $producto->getPrecio() * $cantidad;
            }

            $pedido = new Pedido();
            $pedido->setUsuarioId($usuario->getId())
                   ->setTotal($total)
                   ->setFecha(date('Y-m-d H:i:s'))
                   ->setEstado('completado');

            $pedidoRepo = App::getRepository(PedidoRepository::class);
            $pedidoRepo->guardarPedidoCompleto($pedido, $lineas);

            // Descontar stock
            foreach ($carrito as $productoId => $cantidad) {
                $producto = $repo->find((int)$productoId);
                $producto->setStock($producto->getStock() - $cantidad);
                $repo->update($producto);
            }

            // Vaciar carrito
            $_SESSION['carrito'] = [];

            App::get('logger')->add("Pedido completado por usuario ID: " . $usuario->getId() . " | Total: $total€");
            FlashMessage::set('carrito-mensaje', '¡Compra realizada con éxito! Gracias por tu pedido.');
            App::get('router')->redirect('perfil');

        } catch (\Exception $e) {
            FlashMessage::set('carrito-error', [$e->getMessage()]);
            App::get('router')->redirect('carrito');
        }
    }
}
