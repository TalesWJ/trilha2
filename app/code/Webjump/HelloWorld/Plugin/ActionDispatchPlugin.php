<?php

declare(strict_types=1);

namespace Webjump\HelloWorld\Plugin;

use Closure;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Action\Action;
use Webjump\HelloWorld\Model\CustomLogger;

class ActionDispatchPlugin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ActionDispatchPlugin constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Plugin that Logs before Dispatch Method
     *
     * @param Action $subject
     * @param RequestInterface $request
     *
     * @return array
     */
    public function beforeDispatch(
        Action $subject,
        RequestInterface $request
    ) {
        $this->logger->debug("Before dispatch message.");
        return [$request];
    }

    /**
     * Plugin that Logs after Dispatch Method
     *
     * @param Action $subject
     * @param $result
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function afterDispatch(
        Action $subject,
        $result,
        RequestInterface $request
    ) {
        $this->logger->critical("After dispatch message.");
        return $result;
    }

    /**
     * Plugin that Logs around Dispatch Method
     *
     * @param Action $subject
     * @param Closure $proceed
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function aroundDispatch(
        Action $subject,
        Closure $proceed,
        RequestInterface $request
    ) {
        $this->logger->debug("Around dispatch message.");
        return $proceed($request);
    }
}
