<?php

namespace dwes\core;

use dwes\app\exceptions\AppException;
use dwes\core\database\Connection;
use dwes\core\database\QueryBuilder;

class App
{
    private static array $container = [];

    public static function bind(string $key, $value): void
    {
        static::$container[$key] = $value;
    }

    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$container))
            throw new AppException("No se ha encontrado el valor para la clave: $key");

        return static::$container[$key];
    }

    public static function getConnection()
    {
        if (!array_key_exists('connection', static::$container))
            static::$container['connection'] = Connection::make();

        return static::$container['connection'];
    }

    public static function getRepository(string $className): QueryBuilder
    {
        if (!array_key_exists($className, static::$container))
            static::$container[$className] = new $className();

        return static::$container[$className];
    }
}
