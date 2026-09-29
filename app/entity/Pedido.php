<?php

namespace dwes\app\entity;

use dwes\core\database\IEntity;

class Pedido implements IEntity
{
    private ?int $id = null;
    private int $usuario_id  = 0;
    private string $fecha = '';
    private float  $total = 0.0;
    private string $estado = 'completado';

    public function __construct() {}

    public function getId(): ?int { return $this->id; }
    public function getUsuarioId(): int { return $this->usuario_id; }
    public function getFecha(): string { return $this->fecha; }
    public function getTotal(): float { return $this->total; }
    public function getEstado(): string { return $this->estado; }

    public function setUsuarioId(int $v): self
    {
        $this->usuario_id = $v;
        return $this;
    }
    public function setFecha(string $v): self
    {
        $this->fecha = $v;
        return $this;
    }
    public function setTotal(float $v): self
    {
        $this->total = $v;
        return $this;
    }
    public function setEstado(string $v): self
    {
        $this->estado = $v;
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'usuario_id' => $this->usuario_id,
            'fecha'      => $this->fecha ?: date('Y-m-d H:i:s'),
            'total'      => $this->total,
            'estado'     => $this->estado,
        ];
        if ($this->id !== null) $data['id'] = $this->id;
        return $data;
    }
}
