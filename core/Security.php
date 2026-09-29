<?php

namespace dwes\core;

class Security
{
    public static function isUserGranted(string $role): bool
    {
        if ($role === 'ROLE_ANONYMOUS') return true;

        $usuario = App::get('appUser');

        if (is_null($usuario)) return false;

        $roles      = App::get('config')['security']['roles'];
        $valorReq   = $roles[$role] ?? 1;
        $valorUser  = $roles[$usuario->getRol()] ?? 1;

        return $valorUser >= $valorReq;
    }

    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function checkPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
