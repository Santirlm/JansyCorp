<?php

namespace dwes\app\repository;

use dwes\app\entity\Categoria;
use dwes\core\database\QueryBuilder;

class CategoriaRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('categorias', Categoria::class);
    }

    public function findActivas(): array
    {
        return $this->findBy(['activa' => 1]);
    }

    public function tieneProductos(int $categoriaId): bool
    {
        $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = :id");
        $stmt->execute(['id' => $categoriaId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
