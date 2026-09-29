<?php

namespace dwes\app\repository;

use dwes\app\entity\LineaPedido;
use dwes\core\database\QueryBuilder;

class LineaPedidoRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('lineas_pedido', LineaPedido::class);
    }
}
