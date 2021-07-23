<?php
declare(strict_types=1);

namespace Webjump\RoutesExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
/**
 * Class Index
 */
class RedirectController extends Action implements HttpGetActionInterface
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);

        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Redirect
     */

    public function execute()
    {
        $result = $this->redirectFactory->create();
        $result->setPath('*/*/JsonController');
        return $result;
    }
}
