<?php

namespace dwes\app\controllers;

use dwes\app\exceptions\FileException;
use dwes\app\repository\PedidoRepository;
use dwes\app\repository\ProductoRepository;
use dwes\app\repository\UsuarioRepository;
use dwes\app\utils\File;
use dwes\core\App;
use dwes\core\Response;
use dwes\core\Security;
use dwes\core\helpers\FlashMessage;
use dwes\core\helpers\I18n;

class PerfilController
{
    public function index(): void
    {
        $usuario = App::get('appUser');
        $errores = FlashMessage::get('perfil-error', []);
        $mensaje = FlashMessage::get('perfil-mensaje', '');
        $pedidos = [];
        $lineasPorPedido = [];

        try {
            $pedidoRepo = App::getRepository(PedidoRepository::class);
            $pedidos = $pedidoRepo->findByUsuario($usuario->getId());
            $prodRepo = App::getRepository(ProductoRepository::class);

            foreach ($pedidos as $pedido) {
                $lineas = $pedidoRepo->getLineas($pedido->getId());
                $detalle = [];
                foreach ($lineas as $linea) {
                    try {
                        $prod = $prodRepo->find($linea->getProductoId());
                        $detalle[] = ['linea' => $linea, 'producto' => $prod];
                    } catch (\Exception $e) {
                        $detalle[] = ['linea' => $linea, 'producto' => null];
                    }
                }
                $lineasPorPedido[$pedido->getId()] = $detalle;
            }
        } catch (\Exception $e) {
            $errores[] = 'No se pudieron cargar los pedidos';
        }

        Response::renderView('perfil', 'layout', compact(
            'usuario', 'errores', 'mensaje', 'pedidos', 'lineasPorPedido'
        ));
    }

    public function cambiarPassword(): void
    {
        try {
            $actual = $_POST['password_actual']   ?? '';
            $nueva = $_POST['password_nueva']    ?? '';
            $confirma = $_POST['password_confirma'] ?? '';

            if (empty($actual) || empty($nueva) || empty($confirma))
                throw new \Exception('Todos los campos de contraseña son obligatorios');

            $usuario = App::get('appUser');

            if (!Security::checkPassword($actual, $usuario->getPassword()))
                throw new \Exception('La contraseña actual no es correcta');

            if (strlen($nueva) < 6)
                throw new \Exception('La nueva contraseña debe tener al menos 6 caracteres');

            if ($nueva !== $confirma)
                throw new \Exception('Las nuevas contraseñas no coinciden');

            $usuario->setPassword(Security::encrypt($nueva));
            App::getRepository(UsuarioRepository::class)->update($usuario);
            FlashMessage::set('perfil-mensaje', 'Contraseña actualizada correctamente.');

        } catch (\Exception $e) {
            FlashMessage::set('perfil-error', [$e->getMessage()]);
        }

        App::get('router')->redirect('perfil');
    }

    public function cambiarFoto(): void
    {
        try {
            $file = new File('foto', ['image/jpeg', 'image/jpg', 'image/png']);
            $rutaDest = __DIR__ . '/../../public/assets/avatares/';
            if (!is_dir($rutaDest)) mkdir($rutaDest, 0777, true);

            $file->saveUploadFile($rutaDest);

            $usuario = App::get('appUser');
            $usuario->setImgPerfil($file->getFileName());
            App::getRepository(UsuarioRepository::class)->update($usuario);
            FlashMessage::set('perfil-mensaje', 'Foto de perfil actualizada correctamente.');

        } catch (FileException $e) {
            FlashMessage::set('perfil-error', [$e->getMessage()]);
        } catch (\Exception $e) {
            FlashMessage::set('perfil-error', ['Error: ' . $e->getMessage()]);
        }

        App::get('router')->redirect('perfil');
    }

    public function cambiarIdioma(): void
    {
        try {
            $lang = $_POST['lang'] ?? 'es';
            $locale = I18n::resolverIdioma($lang) ?? I18n::IDIOMA_DEFECTO;

            $usuario = App::get('appUser');
            $usuario->setIdioma($locale);
            App::getRepository(UsuarioRepository::class)->update($usuario);

            $_SESSION['idioma'] = $locale;
            I18n::aplicar($locale);
            FlashMessage::set('perfil-mensaje', 'Idioma actualizado correctamente.');

        } catch (\Exception $e) {
            FlashMessage::set('perfil-error', [$e->getMessage()]);
        }

        App::get('router')->redirect('perfil');
    }
}
