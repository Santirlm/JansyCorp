<?php

namespace dwes\app\controllers;

use dwes\app\entity\Categoria;
use dwes\app\entity\Producto;
use dwes\app\entity\Usuario;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\CategoriaRepository;
use dwes\app\repository\ProductoRepository;
use dwes\app\repository\UsuarioRepository;
use dwes\app\utils\File;
use dwes\core\App;
use dwes\core\Response;
use dwes\core\Security;
use dwes\core\helpers\FlashMessage;

class AdminController
{
    /* =============================================================
     *  PANEL PRINCIPAL
     * ============================================================= */

    public function index(): void
    {
        Response::renderView('admin/index', 'layout');
    }

    /* =============================================================
     *  GESTIÓN DE PRODUCTOS
     * ============================================================= */

    public function productos(): void
    {
        $errores = FlashMessage::get('admin-error', []);
        $mensaje = FlashMessage::get('admin-mensaje', '');
        $productos = [];
        $categorias = [];
        try {
            $productos = App::getRepository(ProductoRepository::class)->findAll();
            $categorias = App::getRepository(CategoriaRepository::class)->findAll();
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
        }
        Response::renderView('admin/productos', 'layout', compact('productos', 'categorias', 'errores', 'mensaje'));
    }

    public function crearProducto(): void
    {
        $categorias = App::getRepository(CategoriaRepository::class)->findAll();
        $errores = FlashMessage::get('admin-error', []);
        $datos = FlashMessage::get('admin-datos', []);
        Response::renderView('admin/producto-form', 'layout', compact('categorias', 'errores', 'datos'));
    }

    public function guardarProducto(): void
    {
        try {
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? '';
            $stock = $_POST['stock']  ?? '';
            $categoriaId = $_POST['categoria_id'] ?? '';
            $datos = compact('nombre', 'descripcion', 'precio', 'stock', 'categoriaId');
            FlashMessage::set('admin-datos', $datos);

            if (empty($nombre))       throw new \Exception('El nombre es obligatorio');
            if ($precio === '')       throw new \Exception('El precio es obligatorio');
            if ($stock === '')        throw new \Exception('El stock es obligatorio');
            if (empty($categoriaId))  throw new \Exception('La categoría es obligatoria');

            $tiposAceptados = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file = new File('imagen', $tiposAceptados);

            $rutaNormal = __DIR__ . '/../../public/' . Producto::RUTA_IMAGENES;
            $rutaMiniatura = __DIR__ . '/../../public/' . Producto::RUTA_IMAGENES_MINIATURA;
            foreach ([$rutaNormal, $rutaMiniatura] as $dir) {
                if (!is_dir($dir)) mkdir($dir, 0777, true);
            }

            $file->saveUploadFile($rutaNormal);
            $file->copyFile($rutaNormal, $rutaMiniatura);

            $producto = new Producto();
            $producto->setNombre($nombre)
                     ->setDescripcion($descripcion)
                     ->setPrecio((float)$precio)
                     ->setStock((int)$stock)
                     ->setCategoriaId((int)$categoriaId)
                     ->setImagen($file->getFileName())
                     ->setUsuarioId(App::get('appUser')->getId())
                     ->setFechaAlta(date('Y-m-d H:i:s'));
            App::getRepository(ProductoRepository::class)->save($producto);
            App::get('logger')->add("Admin: producto creado - $nombre");
            FlashMessage::unset('admin-datos');
            FlashMessage::set('admin-mensaje', "Producto '$nombre' creado correctamente.");
        } catch (FileException $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
            App::get('router')->redirect('admin/productos/crear');
            return;
        } catch (\Exception $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
            App::get('router')->redirect('admin/productos/crear');
            return;
        }
        App::get('router')->redirect('admin/productos');
    }

    public function editarProducto(string $id): void
    {
        try {
            $producto = App::getRepository(ProductoRepository::class)->find((int)$id);
            $categorias = App::getRepository(CategoriaRepository::class)->findAll();
            $errores = FlashMessage::get('admin-error', []);
            Response::renderView('admin/producto-form', 'layout', compact('producto', 'categorias', 'errores'));
        } catch (\Exception $e) {
            App::get('router')->redirect('admin/productos');
        }
    }

    public function actualizarProducto(string $id): void
    {
        try {
            $repo = App::getRepository(ProductoRepository::class);
            $producto = $repo->find((int)$id);
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? '';
            $stock = $_POST['stock']  ?? '';
            $categoriaId = $_POST['categoria_id'] ?? '';
            if (empty($nombre))      throw new \Exception('El nombre es obligatorio');
            if ($precio === '')      throw new \Exception('El precio es obligatorio');
            if ($stock === '')       throw new \Exception('El stock es obligatorio');
            if (empty($categoriaId)) throw new \Exception('La categoría es obligatoria');

            $producto->setNombre($nombre)
                     ->setDescripcion($descripcion)
                     ->setPrecio((float)$precio)
                     ->setStock((int)$stock)
                     ->setCategoriaId((int)$categoriaId);
            // Si se sube nueva imagen
            if (!empty($_FILES['imagen']['name'])) {
                $tiposAceptados = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $file = new File('imagen', $tiposAceptados);
                $rutaNormal = __DIR__ . '/../../public/' . Producto::RUTA_IMAGENES;
                $rutaMiniatura = __DIR__ . '/../../public/' . Producto::RUTA_IMAGENES_MINIATURA;
                $file->saveUploadFile($rutaNormal);
                $file->copyFile($rutaNormal, $rutaMiniatura);
                $producto->setImagen($file->getFileName())
                     ->setUsuarioId(App::get('appUser')->getId())
                     ->setFechaAlta(date('Y-m-d H:i:s'));
            }

            $repo->update($producto);
            FlashMessage::set('admin-mensaje', "Producto actualizado correctamente.");
        } catch (\Exception $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
        }
        App::get('router')->redirect('admin/productos');
    }

    public function eliminarProducto(string $id): void
    {
        try {
            $repo = App::getRepository(ProductoRepository::class);
            if ($repo->tienePedidos((int)$id)) {
                FlashMessage::set('admin-error', ['No se puede eliminar: el producto tiene pedidos asociados.']);
            } else {
                $repo->delete((int)$id);
                FlashMessage::set('admin-mensaje', 'Producto eliminado correctamente.');
            }
        } catch (\Exception $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
        }

        App::get('router')->redirect('admin/productos');
    }

    /* =============================================================
     *  GESTIÓN DE USUARIOS
     * ============================================================= */

    public function usuarios(): void
    {
        $errores = FlashMessage::get('admin-error', []);
        $mensaje = FlashMessage::get('admin-mensaje', '');
        $usuarios = [];
        $filtroRol = $_GET['rol'] ?? '';

        try {
            $repo = App::getRepository(UsuarioRepository::class);
            $usuarios = empty($filtroRol)
                ? $repo->findAll()
                : $repo->findBy(['rol' => $filtroRol]);
        } catch (QueryException $e) {
            $errores[] = $e->getMessage();
        }

        Response::renderView('admin/usuarios', 'layout', compact('usuarios', 'errores', 'mensaje', 'filtroRol'));
    }

    public function cambiarRolUsuario(string $id): void
    {
        try {
            $repo = App::getRepository(UsuarioRepository::class);
            $usuario = $repo->find((int)$id);
            $nuevoRol = $_POST['rol'] ?? '';

            $rolesValidos = ['ROLE_USER', 'ROLE_ADMIN'];
            if (!in_array($nuevoRol, $rolesValidos))
                throw new \Exception('Rol no válido');

            // No degradarse a uno mismo
            $userActual = App::get('appUser');
            if ($userActual->getId() === (int)$id)
                throw new \Exception('No puedes cambiar tu propio rol');

            $usuario->setRol($nuevoRol);
            $repo->update($usuario);
            FlashMessage::set('admin-mensaje', 'Rol actualizado correctamente.');

        } catch (\Exception $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
        }

        App::get('router')->redirect('admin/usuarios');
    }

    public function eliminarUsuario(string $id): void
    {
        try {
            $repo = App::getRepository(UsuarioRepository::class);

            $userActual = App::get('appUser');
            if ($userActual->getId() === (int)$id)
                throw new \Exception('No puedes eliminarte a ti mismo');

            if ($repo->tienePedidos((int)$id))
                throw new \Exception('No se puede eliminar: el usuario tiene pedidos asociados.');

            $repo->delete((int)$id);
            FlashMessage::set('admin-mensaje', 'Usuario eliminado correctamente.');

        } catch (\Exception $e) {
            FlashMessage::set('admin-error', [$e->getMessage()]);
        }
        App::get('router')->redirect('admin/usuarios');
    }
}
