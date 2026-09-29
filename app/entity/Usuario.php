<?php

namespace dwes\app\entity;

use dwes\core\database\IEntity;

class Usuario implements IEntity
{
    private ?int    $id         = null;
    private string  $nombre     = '';
    private string  $apellido   = '';
    private string  $email      = '';
    private string  $password   = '';
    private string  $rol        = 'ROLE_USER';
    private string  $telefono   = '';
    private ?string $direccion  = null;
    private ?string $imgPerfil  = null;
    private string  $fechaAlta  = '';
    private string  $idioma     = 'es_ES';

    public function __construct() {}

    public function getId(): ?int            { return $this->id; }
    public function getNombre(): string       { return $this->nombre; }
    public function getApellido(): string     { return $this->apellido; }
    public function getEmail(): string        { return $this->email; }
    public function getPassword(): string     { return $this->password; }
    public function getRol(): string          { return $this->rol; }
    public function getTelefono(): string     { return $this->telefono; }
    public function getDireccion(): ?string   { return $this->direccion; }
    public function getImgPerfil(): ?string   { return $this->imgPerfil; }
    public function getFechaAlta(): string    { return $this->fechaAlta; }
    public function getIdioma(): string       { return $this->idioma; }

    public function setNombre(string $v): self     { $this->nombre    = $v; return $this; }
    public function setApellido(string $v): self   { $this->apellido  = $v; return $this; }
    public function setEmail(string $v): self      { $this->email     = $v; return $this; }
    public function setPassword(string $v): self   { $this->password  = $v; return $this; }
    public function setRol(string $v): self        { $this->rol       = $v; return $this; }
    public function setTelefono(string $v): self   { $this->telefono  = $v; return $this; }
    public function setDireccion(?string $v): self { $this->direccion = $v; return $this; }
    public function setImgPerfil(?string $v): self { $this->imgPerfil = $v; return $this; }
    public function setFechaAlta(string $v): self  { $this->fechaAlta = $v; return $this; }
    public function setIdioma(string $v): self     { $this->idioma    = $v; return $this; }

    public function getNombreCompleto(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }

    public function toArray(): array
    {
        $data = [
            'nombre'    => $this->nombre,
            'apellido'  => $this->apellido,
            'email'     => $this->email,
            'password'  => $this->password,
            'rol'       => $this->rol,
            'telefono'  => $this->telefono,
            'direccion' => $this->direccion,
            'imgPerfil' => $this->imgPerfil,
            'fechaAlta' => $this->fechaAlta ?: date('Y-m-d H:i:s'),
            'idioma'    => $this->idioma,
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
