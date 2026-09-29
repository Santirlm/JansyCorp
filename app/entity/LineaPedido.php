<?php

namespace dwes\app\entity;

use dwes\core\database\IEntity;

class LineaPedido implements IEntity
{
    private ?int  $id = null;
    private int $pedido_id = 0;
    private int $producto_id = 0;
    private int $cantidad = 1;
    private float $precio_unit = 0.0;

    public function __construct() {}

    public function getId(): ?int { return $this->id; }
    public function getPedidoId(): int { return $this->pedido_id; }
    public function getProductoId(): int { return $this->producto_id; }
    public function getCantidad(): int { return $this->cantidad; }
    public function getPrecioUnit(): float { return $this->precio_unit; }
    public function getSubtotal(): float { return $this->cantidad * $this->precio_unit; }

    public function setPedidoId(int $v): self
    {
        $this->pedido_id = $v;
        return $this;
    }
    public function setProductoId(int $v): self
    {
        $this->producto_id = $v;
        return $this;
    }
    public function setCantidad(int $v): self
    {
        $this->cantidad = $v;
        return $this;
    }
    public function setPrecioUnit(float $v): self
    {
        $this->precio_unit = $v;
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'pedido_id'   => $this->pedido_id,
            'producto_id' => $this->producto_id,
            'cantidad'    => $this->cantidad,
            'precio_unit' => $this->precio_unit,
        ];
        if ($this->id !== null) $data['id'] = $this->id;
        return $data;
    }
}
