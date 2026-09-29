<?php

namespace dwes\app\repository;

use dwes\app\entity\Categoria;
use dwes\app\entity\Producto;
use dwes\core\database\QueryBuilder;

class ProductoRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('productos', Producto::class);
    }

    public function getCategoria(Producto $producto): ?Categoria
    {
        if ($producto->getCategoriaId() === null) return null;
        $repo = new CategoriaRepository();
        return $repo->find($producto->getCategoriaId());
    }

    /** Todos los productos ordenados por fecha descendente */
    public function findAllOrdenados(): array
    {
        $stmt = $this->getConnection()->prepare(
            "SELECT * FROM productos ORDER BY fechaAlta DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Producto::class);
    }

    public function findByCategoria(int $categoriaId): array
    {
        $stmt = $this->getConnection()->prepare(
            "SELECT * FROM productos WHERE categoria_id = :cid ORDER BY fechaAlta DESC"
        );
        $stmt->execute(['cid' => $categoriaId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Producto::class);
    }

    /** Búsqueda en nombre Y descripción */
    public function buscar(string $texto): array
    {
        $stmt = $this->getConnection()->prepare(
            "SELECT * FROM productos WHERE nombre LIKE :q OR descripcion LIKE :q ORDER BY fechaAlta DESC"
        );
        $stmt->execute(['q' => '%' . $texto . '%']);
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Producto::class);
    }

    /** Productos de un usuario concreto */
    public function findByUsuario(int $usuarioId): array
    {
        $stmt = $this->getConnection()->prepare(
            "SELECT * FROM productos WHERE usuario_id = :uid ORDER BY fechaAlta DESC"
        );
        $stmt->execute(['uid' => $usuarioId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Producto::class);
    }

    public function tienePedidos(int $productoId): bool
    {
        $stmt = $this->getConnection()->prepare(
            "SELECT COUNT(*) FROM lineas_pedido WHERE producto_id = :id"
        );
        $stmt->execute(['id' => $productoId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
