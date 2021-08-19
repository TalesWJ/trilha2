<?php

declare(strict_types=1);

namespace Webjump\Pets\Controller\Adminhtml\Pet;

use Webjump\Pets\Api\PetRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Edit
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var PetRepositoryInterface
     */
    private PetRepositoryInterface $petRepository;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PetRepositoryInterface $petRepository
     */
    public function __construct(
        Context $context,
        PetRepositoryInterface $petRepository
    ) {
        parent::__construct($context);
        $this->petRepository = $petRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $petKindId = (int)$this->getRequest()->getParam('entity_id');

        if ($petKindId) {
            try {
                $this->petRepository->getById($petKindId);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__($exception->getMessage()));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/petkind');
            }
        }

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Webjump_Pets::webjumppets');
        $resultPage->getConfig()->getTitle()->prepend(__('Pet Kind'));

        return $resultPage;
    }
}

