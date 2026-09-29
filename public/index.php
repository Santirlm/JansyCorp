<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['es', 'en'])) {
    $_SESSION['idioma'] = $_GET['lang'] === 'en' ? 'en_GB' : 'es_ES';
} elseif (!isset($_SESSION['idioma'])) {
    $navegador = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'es', 0, 2);
    $_SESSION['idioma'] = ($navegador === 'en') ? 'en_GB' : 'es_ES';
}

$locale   = $_SESSION['idioma'];
$language = $locale . '.utf8';

putenv("LANG=$language");
putenv("LANGUAGE=$language");
putenv("LC_ALL=$language");
setlocale(LC_ALL, $language);

$localePath = __DIR__ . '/locale';
bindtextdomain('messages', $localePath);
bind_textdomain_codeset('messages', 'UTF-8');
textdomain('messages');
// ─────────────────────────────────────────────────────────────

use dwes\app\exceptions\AppException;
use dwes\core\App;
use dwes\core\Request;

try {
    require __DIR__ . '/../core/bootstrap.php';
    App::get('router')->direct(Request::uri(), Request::method());
} catch (AppException $e) {
    $e->handleError();
}