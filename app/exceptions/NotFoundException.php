<?php
namespace dwes\app\exceptions;
class NotFoundException extends AppException {
    public function __construct(string $message, int $code = 404) { parent::__construct($message, $code); }
}
