<?php

namespace dwes\app\entity;

use dwes\core\database\IEntity;

class Categoria implements IEntity
{
    private ?int $id = null;
    private string $nombre = '';
    private ?string $descripcion = null;
    private int $activa = 1;

    public function __construct() {}

    public function getId(): ?int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function getActiva(): bool { return (bool) $this->activa; }
    public function setNombre(string $v): self
    {
        $this->nombre = $v;
        return $this;
    }
    public function setDescripcion(?string $v): self
    {
        $this->descripcion = $v;
        return $this;
    }
    public function setActiva(bool $v): self
    {
        $this->activa = (int)$v;
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
            'activa'      => $this->activa,
        ];
        if ($this->id !== null) $data['id'] = $this->id;
        return $data;
    }
}
