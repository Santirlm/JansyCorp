<?php

namespace dwes\app\exceptions;

use dwes\core\Response;
use Exception;

class AppException extends Exception
{
    public function __construct(string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function getHttpHeaderMessage(): string
    {
        return match ($this->getCode()) {
            404 => 'Not Found',
            403 => 'Forbidden',
            500 => 'Internal Server Error',
            default => 'Unknown Error',
        };
    }

    public function handleError(): void
    {
        try {
            $httpHeaderMessage = $this->getHttpHeaderMessage();
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $this->getCode() . ' ' . $httpHeaderMessage, true, $this->getCode());
            $errorMessage = $this->getMessage();
            Response::renderView('error', 'layout', compact('httpHeaderMessage', 'errorMessage'));
        } catch (Exception $e) {
            die('Error en el manejador de excepciones');
        }
    }
}
