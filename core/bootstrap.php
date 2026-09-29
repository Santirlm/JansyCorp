<?php

use dwes\app\repository\UsuarioRepository;
use dwes\app\utils\MyLog;
use dwes\core\App;
use dwes\core\Router;
use dwes\core\helpers\Url;

require __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);

$router = Router::load(__DIR__ . '/../app/' . $config['routes']['filename']);
App::bind('router', $router);

$logger = MyLog::load(__DIR__ . '/../logs/' . $config['logs']['filename'], $config['logs']['level']);
App::bind('logger', $logger);

$appUser = null;
if (isset($_SESSION['logedUser'])) {
    try {
        $appUser = App::getRepository(UsuarioRepository::class)->find($_SESSION['logedUser']);
    } catch (\Exception $e) {
        unset($_SESSION['logedUser']);
    }
}
App::bind('appUser', $appUser);

if ($appUser !== null && method_exists($appUser, 'getIdioma')) {
    $idioma   = $appUser->getIdioma();
    $language = $idioma . '.utf8';
    putenv("LANG=$language");
    putenv("LANGUAGE=$language");
    putenv("LC_ALL=$language");
    setlocale(LC_ALL, $language);
    bindtextdomain('messages', __DIR__ . '/../public/locale');
    bind_textdomain_codeset('messages', 'UTF-8');
    textdomain('messages');
    $_SESSION['idioma'] = $idioma;
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        return \dwes\core\helpers\Url::to($path);
    }
}