<?php

namespace dwes\app\repository;

use dwes\app\entity\LineaPedido;
use dwes\app\entity\Pedido;
use dwes\app\exceptions\QueryException;
use dwes\core\database\QueryBuilder;

class PedidoRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('pedidos', Pedido::class);
    }

    public function findByUsuario(int $usuarioId): array
    {
        return $this->findBy(['usuario_id' => $usuarioId]);
    }

    public function getLineas(int $pedidoId): array
    {
        $sql  = "SELECT * FROM lineas_pedido WHERE pedido_id = :pedido_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['pedido_id' => $pedidoId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, LineaPedido::class);
    }

    /**
     * Guarda un pedido completo con sus líneas en una transacción.
     * Devuelve el id del pedido creado.
     */
    public function guardarPedidoCompleto(Pedido $pedido, array $lineas): int
    {
        $pedidoId = 0;

        $this->executeTransaction(function () use ($pedido, $lineas, &$pedidoId) {
            $pedidoId = $this->save($pedido);

            $lineaRepo = new LineaPedidoRepository();
            foreach ($lineas as $linea) {
                /** @var LineaPedido $linea */
                $linea->setPedidoId($pedidoId);
                $lineaRepo->save($linea);
            }
        });

        return $pedidoId;
    }
}
