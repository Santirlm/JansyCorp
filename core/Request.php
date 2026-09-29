<?php

namespace dwes\core;

class Request
{
    /**
     * Devuelve la URI limpia relativa al subdirectorio del proyecto.
     * Funciona tanto con VirtualHost apuntando a /public
     * como con acceso por subdirectorio (/JansyCorp_Proyecto_SantiagoRamirez/public/).
     */
    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Calcular el subdirectorio base desde SCRIPT_NAME
        // SCRIPT_NAME = /JansyCorp_Proyecto_SantiagoRamirez/public/index.php
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

        // Quitar el prefijo del subdirectorio si existe
        if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return trim($uri, '/');
    }

    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
