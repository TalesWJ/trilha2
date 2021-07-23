<?php
declare(strict_types=1);

namespace Webjump\RoutesExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
/**
 * Class Index
 */
class ForwardController extends Action implements HttpGetActionInterface
{
    /**
     * @var ForwardFactory
     */
    private ForwardFactory $forwardFactory;

    /**
     * @param Context $context
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $forwardFactory
    ) {
        parent::__construct($context);

        $this->forwardFactory = $forwardFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Forward
     */

    public function execute()
    {
        $result = $this->forwardFactory->create();
        $result->forward('JsonController');
        return $result;
    }
}
