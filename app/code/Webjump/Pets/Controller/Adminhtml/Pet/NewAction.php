<?php

declare(strict_types=1);

namespace Webjump\Pets\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 */
class NewAction extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Webjump_Pets::new';
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        $resultPage->forward('edit');
        return $resultPage;
    }
}
