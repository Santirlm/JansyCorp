<?php

namespace dwes\core\helpers;

class I18n
{
    const IDIOMAS = [
        'es' => 'es_ES',
        'en' => 'en_GB',
    ];

    const IDIOMA_DEFECTO = 'es_ES';

    public static function initSinUsuario(): void
    {
        $idioma = null;

        if (isset($_GET['lang'])) {
            $lang   = trim(strip_tags($_GET['lang']));
            $idioma = self::resolverIdioma($lang);
            if ($idioma) $_SESSION['idioma'] = $idioma;
        }

        if ($idioma === null && isset($_SESSION['idioma'])) {
            $idioma = $_SESSION['idioma'];
        }

        if ($idioma === null) {
            $idioma = self::detectarNavegador();
        }

        $_SESSION['idioma'] = $idioma;
        self::aplicar($idioma);
    }

    public static function init(?object $usuario = null): void
    {
        $idioma = null;

        if ($usuario !== null && method_exists($usuario, 'getIdioma')) {
            $idioma = $usuario->getIdioma();
        }

        if ($usuario === null && isset($_GET['lang'])) {
            $lang   = trim(strip_tags($_GET['lang']));
            $idioma = self::resolverIdioma($lang);
        }

        if ($idioma === null && isset($_SESSION['idioma'])) {
            $idioma = $_SESSION['idioma'];
        }

        if ($idioma === null) {
            $idioma = self::detectarNavegador();
        }

        $_SESSION['idioma'] = $idioma;
        self::aplicar($idioma);
    }

    public static function aplicar(string $locale): void
    {
        $language = $locale . '.utf8';

        putenv("LANG=$language");
        putenv("LANGUAGE=$language");
        putenv("LC_ALL=$language");
        setlocale(LC_ALL, $language);

        $localePath = realpath(__DIR__ . '/../../../public/locale');
        bindtextdomain('messages', $localePath);
        bind_textdomain_codeset('messages', 'UTF-8');
        textdomain('messages');
    }

    public static function detectarNavegador(): string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return self::IDIOMA_DEFECTO;
        }

        $langs = [];
        preg_match_all(
            '/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
            $_SERVER['HTTP_ACCEPT_LANGUAGE'],
            $parsed
        );

        if (count($parsed[1])) {
            $langs = array_combine($parsed[1], $parsed[4]);
            foreach ($langs as $lang => $val) {
                if ($val === '') $langs[$lang] = 1;
            }
            arsort($langs, SORT_NUMERIC);
        }

        foreach ($langs as $lang => $prioridad) {
            $resuelto = self::resolverIdioma($lang);
            if ($resuelto !== null) return $resuelto;
        }

        return self::IDIOMA_DEFECTO;
    }

    public static function resolverIdioma(string $lang): ?string
    {
        $lang = strtolower(str_replace('-', '_', $lang));

        foreach (self::IDIOMAS as $codigo => $locale) {
            if (strtolower($locale) === $lang) return $locale;
        }

        $prefijo = substr($lang, 0, 2);
        return self::IDIOMAS[$prefijo] ?? null;
    }

    public static function getActivo(): string
    {
        return $_SESSION['idioma'] ?? self::IDIOMA_DEFECTO;
    }

    public static function getNombreActivo(): string
    {
        return match (self::getActivo()) {
            'en_GB' => 'English',
            default => 'Español',
        };
    }
}