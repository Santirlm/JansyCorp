<?php

namespace dwes\core\database;

use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\QueryException;
use dwes\core\App;
use PDO;
use PDOException;

abstract class QueryBuilder
{
    private $connection;
    private $table;
    private $classEntity;

    public function __construct(string $table, string $classEntity)
    {
        $this->connection  = App::getConnection();
        $this->table       = $table;
        $this->classEntity = $classEntity;
    }

    private function executeQuery(string $query, array $parameters = []): array
    {
        $pdoStatement = $this->connection->prepare($query);

        if ($pdoStatement->execute($parameters) === false)
            throw new QueryException("Error al ejecutar la consulta");

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }

    public function findAll(): array
    {
        return $this->executeQuery("SELECT * FROM $this->table");
    }

    public function find(int $id): IEntity
    {
        $result = $this->executeQuery("SELECT * FROM $this->table WHERE id = $id");

        if (empty($result))
            throw new NotFoundException("No se ha encontrado el registro con id $id");

        return $result[0];
    }

    private function getFilters(array $filters): string
    {
        if (empty($filters)) return '';

        $strFilters = [];
        foreach ($filters as $key => $value)
            $strFilters[] = $key . '=:' . $key;

        return 'WHERE ' . implode(' AND ', $strFilters);
    }

    public function findBy(array $filters): array
    {
        $sql = "SELECT * FROM $this->table " . $this->getFilters($filters);
        return $this->executeQuery($sql, $filters);
    }

    public function findOneBy(array $filters): ?IEntity
    {
        $result = $this->findBy($filters);
        return count($result) > 0 ? $result[0] : null;
    }

    public function save(IEntity $entity): int
    {
        try {
            $parameters = $entity->toArray();

            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $this->table,
                implode(', ', array_keys($parameters)),
                ':' . implode(', :', array_keys($parameters))
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);

            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw new QueryException("Error al insertar en la base de datos: " . $e->getMessage());
        }
    }

    private function getUpdates(array $parameters): string
    {
        $updates = [];
        foreach ($parameters as $key => $value) {
            if ($key !== 'id') $updates[] = "$key=:$key";
        }
        return implode(', ', $updates);
    }

    public function update(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();

            $sql = sprintf(
                "UPDATE %s SET %s WHERE id = :id",
                $this->table,
                $this->getUpdates($parameters)
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $e) {
            throw new QueryException("Error al actualizar en la base de datos");
        }
    }

    public function delete(int $id): void
    {
        try {
            $sql = "DELETE FROM $this->table WHERE id = :id";
            $statement = $this->connection->prepare($sql);
            $statement->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new QueryException("Error al eliminar de la base de datos");
        }
    }

    public function executeTransaction(callable $fn): void
    {
        try {
            $this->connection->beginTransaction();
            $fn();
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw new QueryException("Error al ejecutar la transacción");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
