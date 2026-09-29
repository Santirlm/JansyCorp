<?php
namespace dwes\app\exceptions;
class AuthException extends AppException {
    public function __construct(string $message, int $code = 403) { parent::__construct($message, $code); }
}
