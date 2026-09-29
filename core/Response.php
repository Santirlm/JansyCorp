<?php

namespace dwes\core;

use dwes\core\helpers\Url;

class Response
{
    public static function renderView(string $name, string $layout = 'layout', array $data = []): void
    {
        extract($data);

        $app['user'] = App::get('appUser');
        // Base URL disponible en todas las vistas como $baseUrl
        $baseUrl = Url::base();

        ob_start();
        require __DIR__ . "/../app/views/$name.view.php";
        $mainContent = ob_get_clean();

        require __DIR__ . "/../app/views/$layout.view.php";
    }
}
