<?php

declare(strict_types=1);

namespace Webjump\HelloWorld\Cron;

use Psr\Log\LoggerInterface;

class CronExample
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute() : void
    {
        $this->logger->debug('Crontab rodando!');
    }
}
