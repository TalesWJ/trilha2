<?php

declare(strict_types=1);

namespace Webjump\Pets\Controller\Adminhtml\Pet;

use Magento\Framework\Exception\CouldNotDeleteException;
use Webjump\Pets\Api\PetRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;


/**
 * Delete action class
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var PetRepositoryInterface
     */
    private PetRepositoryInterface $petRepository;

    /**
     * Delete action construct
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
     * Execute delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $petKindId = $this->getRequest()->getParam('entity_id');

        if (!$petKindId) {
            $this->messageManager->addErrorMessage(__("We could not find the desired Pet Kind."));
            return $resultRedirect->setPath('*/*/petkind');
        }

        try {
            $petKind = $this->petRepository->getById($petKindId);
            $this->petRepository->delete($petKind);
            $this->messageManager->addSuccessMessage(__('Success! Pet Kind was saved with no errors.'));
            return $resultRedirect->setPath('*/*/petkind');
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(__("Could not delete the Pet Kind."));
            return $resultRedirect->setPath('*/*/petkind');
        }
    }
}
