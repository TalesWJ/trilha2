<?php
declare(strict_types=1);

namespace Webjump\RoutesExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
/**
 * Class Index
 */
class RawController extends Action implements HttpGetActionInterface
{
    /**
     * @var RawFactory
     */
    private RawFactory $rawFactory;

    /**
     * @param Context $context
     * @param RawFactory $rawFactory
     */
    public function __construct(
        Context $context,
        RawFactory $rawFactory
    ) {
        parent::__construct($context);

        $this->rawFactory = $rawFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Raw
     */

    public function execute()
    {
        $result = $this->rawFactory->create();
        $result->setHeader('Content-Type', 'text/html');
        $result->setContents('<h1>Raw Factory</h1>');
        return $result;
    }
}
