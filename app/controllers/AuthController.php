<?php

namespace dwes\app\controllers;

use dwes\app\entity\Usuario;
use dwes\app\repository\UsuarioRepository;
use dwes\core\App;
use dwes\core\helpers\FlashMessage;
use dwes\core\helpers\I18n;
use dwes\core\Response;
use dwes\core\Security;

class AuthController
{
    /* =========================================================
     *  LOGIN
     * ========================================================= */
    public function login(): void
    {
        // Si ya está logueado → redirigir directamente, sin mostrar login
        if (!is_null(App::get('appUser'))) {
            App::get('router')->redirect('perfil');
            return;
        }
        $errores = FlashMessage::get('login-error', []);
        $email = FlashMessage::get('email', '');
        Response::renderView('login', 'layout', compact('errores', 'email'));
    }

    public function checkLogin(): void
    {
        // Doble check: si ya está logueado no procesar
        if (!is_null(App::get('appUser'))) {
            App::get('router')->redirect('perfil');
            return;
        }
        try {
            $email = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');
            if (!empty($email)) FlashMessage::set('email', $email);
            if (empty($email) || empty($password))
                throw new \Exception('Debes introducir el email y la contraseña');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new \Exception('El email introducido no es válido');
            $usuario = App::getRepository(UsuarioRepository::class)->findOneBy(['email' => $email]);
            if (!is_null($usuario) && Security::checkPassword($password, $usuario->getPassword())) {
                $_SESSION['logedUser'] = $usuario->getId();
                $_SESSION['idioma']    = $usuario->getIdioma();
                I18n::aplicar($usuario->getIdioma());
                FlashMessage::unset('email');
                App::get('router')->redirect('perfil');
                return;
            }
            throw new \Exception('Email o contraseña incorrectos');
        } catch (\Exception $e) {
            FlashMessage::set('login-error', [$e->getMessage()]);
            App::get('router')->redirect('login');
        }
    }

    public function logout(): void
    {
        unset($_SESSION['logedUser']);
        App::get('router')->redirect('');
    }

    /* =========================================================
     *  REGISTRO
     * ========================================================= */
    public function registro(): void
    {
        if (!is_null(App::get('appUser'))) {
            App::get('router')->redirect('perfil');
            return;
        }

        $errores = FlashMessage::get('registro-error', []);
        $datos = FlashMessage::get('registro-datos', []);
        $captchaCodigo = self::generarCaptcha();
        Response::renderView('registro', 'layout', compact('errores', 'datos', 'captchaCodigo'));
    }

    public function checkRegistro(): void
    {
        // Si ya logueado, no registrar
        if (!is_null(App::get('appUser'))) {
            App::get('router')->redirect('perfil');
            return;
        }

        try {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $password= $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $captchaUser = trim($_POST['captcha_user'] ?? '');
            $captchaOculto = trim($_POST['captcha_oculto'] ?? '');

            $datos = compact('nombre', 'apellido', 'email', 'telefono', 'direccion');
            FlashMessage::set('registro-datos', $datos);

            if (empty($nombre))    throw new \Exception('El nombre es obligatorio');
            if (empty($apellido))  throw new \Exception('El apellido es obligatorio');
            if (empty($email))     throw new \Exception('El email es obligatorio');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new \Exception('El email no es válido');
            if (empty($telefono))  throw new \Exception('El teléfono es obligatorio');
            if (empty($direccion)) throw new \Exception('La dirección es obligatoria');
            if (empty($password))  throw new \Exception('La contraseña es obligatoria');
            if (strlen($password) < 6) throw new \Exception('La contraseña debe tener al menos 6 caracteres');
            if ($password !== $confirm) throw new \Exception('Las contraseñas no coinciden');

            // CAPTCHA
            if (empty($captchaUser))
                throw new \Exception('Debes introducir el código de verificación');
            if ($captchaUser !== $captchaOculto)
                throw new \Exception('El código de verificación no es correcto');

            $repo = App::getRepository(UsuarioRepository::class);
            if ($repo->existeEmail($email))
                throw new \Exception('Ya existe una cuenta con ese email');

            $idioma  = I18n::getActivo();
            $usuario = new Usuario();
            $usuario->setNombre($nombre)
                    ->setApellido($apellido)
                    ->setEmail($email)
                    ->setTelefono($telefono)
                    ->setDireccion($direccion)
                    ->setPassword(Security::encrypt($password))
                    ->setRol('ROLE_USER')
                    ->setFechaAlta(date('Y-m-d H:i:s'))
                    ->setImgPerfil('default-avatar.png')
                    ->setIdioma($idioma);

            $id = $repo->save($usuario);

            $_SESSION['logedUser'] = $id;
            $_SESSION['idioma']    = $idioma;
            $nuevoUsuario = $repo->find($id);
            App::bind('appUser', $nuevoUsuario);

            FlashMessage::unset('registro-datos');
            App::get('logger')->add("Nuevo registro: $email");
            App::get('router')->redirect('perfil');

        } catch (\Exception $e) {
            FlashMessage::set('registro-error', [$e->getMessage()]);
            App::get('router')->redirect('registro');
        }
    }

    private static function generarCaptcha(int $longitud = 6): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        $bytes  = random_bytes($longitud);
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $chars[ord($bytes[$i]) % strlen($chars)];
        }
        return $codigo;
    }
}
