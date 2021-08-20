<?php

declare(strict_types=1);

namespace Webjump\Pets\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Api\PetRepositoryInterface;


/**
 * Class Save
 */
class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Webjump_Pets::save';
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var PetRepositoryInterface
     */
    private PetRepositoryInterface $petRepository;

    /**
     * @var PetInterfaceFactory
     */
    private PetInterfaceFactory $petFactory;


    /**
     * Save Action constructor
     *
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param PetRepositoryInterface $petRepository
     * @param PetInterfaceFactory $petFactory
     */
    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory,
        PetRepositoryInterface $petRepository,
        PetInterfaceFactory $petFactory
    ) {
        parent::__construct($context);
        $this->redirectFactory = $redirectFactory;
        $this->petRepository = $petRepository;
        $this->petFactory = $petFactory;
    }

    /**
     * Execute form save
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->redirectFactory->create();
        $postResult = $this->getRequest()->getPostValue();
        $petKind = $this->petFactory->create();
        $petKindId = $this->getRequest()->getParam('entity_id');
        if ($petKindId) {
            try {
                $petKindId = $this->petRepository->getById((int)$petKindId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This PetKind does not exist.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        try {
            $petKind->setData($postResult);
            $this->petRepository->save($petKind);
            $this->messageManager->addSuccessMessage(__('Success! Pet Kind was saved with no errors.'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong when saving the Pet Kind'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
