<?php

namespace dwes\app\repository;

use dwes\app\entity\Usuario;
use dwes\core\database\QueryBuilder;

class UsuarioRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('usuarios', Usuario::class);
    }

    public function existeEmail(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function tienePedidos(int $usuarioId): bool
    {
        $stmt = $this->getConnection()->prepare("SELECT COUNT(*) FROM pedidos WHERE usuario_id = :id");
        $stmt->execute(['id' => $usuarioId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
