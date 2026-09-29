<?php

namespace dwes\app\entity;

use dwes\core\database\IEntity;

class Producto implements IEntity
{
    const RUTA_IMAGENES = 'assets/productos/normal/';
    const RUTA_IMAGENES_MINIATURA = 'assets/productos/miniatura/';

    private ?int    $id = null;
    private string  $nombre = '';
    private float   $precio = 0.0;
    private string  $descripcion = '';
    private int     $stock = 0;
    private string  $imagen= '';
    private ?int    $categoria_id = null;
    private ?int    $usuario_id   = null;
    private string  $fechaAlta    = '';

    public function __construct() {}

    public function getId(): ?int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getPrecio(): float { return $this->precio; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getStock(): int { return $this->stock; }
    public function getImagen(): string { return $this->imagen; }
    public function getCategoriaId(): ?int  { return $this->categoria_id; }
    public function getUsuarioId(): ?int { return $this->usuario_id; }
    public function getFechaAlta(): string { return $this->fechaAlta; }

    public function setNombre(string $v): self
    {
        $this->nombre = $v;
        return $this;
    }
    public function setPrecio(float $v): self
    {
        $this->precio = $v;
        return $this;
    }
    public function setDescripcion(string $v): self
    {
        $this->descripcion  = $v;
        return $this;
    }
    public function setStock(int $v): self
    {
        $this->stock= $v;
        return $this; }
    public function setImagen(string $v): self
    {
        $this->imagen = $v;
        return $this;
    }
    public function setCategoriaId(?int $v): self
    {
        $this->categoria_id = $v;
        return $this;
    }
    public function setUsuarioId(?int $v): self
    {
        $this->usuario_id   = $v;
        return $this;
    }
    public function setFechaAlta(string $v): self
    {
        $this->fechaAlta    = $v; return $this;
    }

    public function getImagenUrl(): string
    {
        return self::RUTA_IMAGENES . $this->imagen;
    }

    public function getUrlMiniatura(): string
    {
        return self::RUTA_IMAGENES_MINIATURA . 'miniatura_' . $this->imagen;
    }

    public function toArray(): array
    {
        $data = [
            'nombre'       => $this->nombre,
            'precio'       => $this->precio,
            'descripcion'  => $this->descripcion,
            'stock'        => $this->stock,
            'imagen'       => $this->imagen,
            'categoria_id' => $this->categoria_id,
            'usuario_id'   => $this->usuario_id,
            'fechaAlta'    => $this->fechaAlta ?: date('Y-m-d H:i:s'),
        ];
        if ($this->id !== null) $data['id'] = $this->id;
        return $data;
    }
}
