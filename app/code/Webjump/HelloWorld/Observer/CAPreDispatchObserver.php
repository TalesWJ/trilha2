<?php

declare(strict_types=1);

namespace Webjump\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;


class CAPreDispatchObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CAPreDispatchObserver constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Observer execute method
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->logger->critical('Observer funcionando');
    }
}
