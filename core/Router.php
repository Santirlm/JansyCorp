<?php

namespace dwes\core;

use dwes\app\exceptions\AppException;
use dwes\app\exceptions\AuthException;
use dwes\app\exceptions\NotFoundException;
use dwes\core\helpers\Url;

class Router
{
    private array $routes;

    private function __construct()
    {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    public static function load(string $file): Router
    {
        $router = new Router();
        require $file;
        return $router;
    }

    public function get(string $uri, string $controller, string $role = 'ROLE_ANONYMOUS'): void
    {
        $this->routes['GET'][$uri] = ['controller' => $controller, 'role' => $role];
    }

    public function post(string $uri, string $controller, string $role = 'ROLE_ANONYMOUS'): void
    {
        $this->routes['POST'][$uri] = ['controller' => $controller, 'role' => $role];
    }

    public function direct(string $uri, string $method): void
    {
        // Ruta exacta
        if (array_key_exists($uri, $this->routes[$method])) {
            $route = $this->routes[$method][$uri];
            $this->checkAndExecute($route['controller'], $route['role'], $uri, []);
            return;
        }

        // Rutas con parámetros (:id, etc.)
        foreach ($this->routes[$method] as $route => $data) {
            if (strpos($route, ':') !== false) {
                $pattern = preg_replace('/:[a-zA-Z0-9_]+/', '([a-zA-Z0-9_]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                    array_shift($matches);
                    $this->checkAndExecute($data['controller'], $data['role'], $uri, $matches);
                    return;
                }
            }
        }

        throw new NotFoundException("No se ha encontrado la ruta: $uri");
    }

    private function checkAndExecute(string $controllerAction, string $role, string $uri, array $params): void
    {
        if (!Security::isUserGranted($role)) {
            if (!is_null(App::get('appUser'))) {
                throw new AuthException('Acceso no autorizado');
            } else {
                $this->redirect('login');
            }
            return;
        }

        [$controller, $action] = explode('@', $controllerAction, 2);
        $fqcn = App::get('config')['project']['namespace'] . '\\app\\controllers\\' . $controller;
        $obj  = new $fqcn();

        if (!method_exists($obj, $action))
            throw new NotFoundException("El controlador $controller no tiene el método $action");

        call_user_func_array([$obj, $action], $params);
    }

    /**
     * Redirige a una ruta relativa, respetando el subdirectorio base.
     */
    public function redirect(string $path): void
    {
        $url = Url::to($path);
        header('Location: ' . $url);
        exit();
    }
}
