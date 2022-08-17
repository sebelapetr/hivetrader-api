<?php

namespace App\Model\Services\ConsoleLogger;

use Contributte\Monolog\LoggerManager;
use Psr\Log\LoggerInterface;

class ConsoleLoggerService
{
    protected LoggerManager $loggerManager;
    public LoggerInterface $consoleLogger;

    public function __construct(LoggerManager $loggerManager)
    {
        $this->loggerManager = $loggerManager;
        $this->consoleLogger = $loggerManager->get("error");
    }
}
