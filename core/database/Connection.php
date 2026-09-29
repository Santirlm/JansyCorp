<?php

namespace dwes\core\database;

use dwes\app\exceptions\AppException;
use dwes\core\App;
use PDO;
use PDOException;

class Connection
{
    public static function make(): PDO
    {
        try {
            $config = App::get('config')['database'];

            $connection = new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            throw new AppException('No se ha podido crear la conexión a la base de datos');
        }

        return $connection;
    }
}
