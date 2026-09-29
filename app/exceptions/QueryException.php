<?php
namespace dwes\app\exceptions;
class QueryException extends AppException {
    public function __construct(string $message, int $code = 500) { parent::__construct($message, $code); }
}
