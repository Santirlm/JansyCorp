<?php

namespace dwes\app\utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MyLog
{
    private Logger $log;
    private int    $level;

    private function __construct(string $filename, int $level)
    {
        $this->level = $level;
        $this->log   = new Logger('jansycorp');
        $this->log->pushHandler(new StreamHandler($filename, $this->level));
    }

    public static function load(string $filename, int $level = Logger::WARNING): MyLog
    {
        return new MyLog($filename, $level);
    }

    public function add(string $message): void
    {
        $this->log->log($this->level, $message);
    }
}
