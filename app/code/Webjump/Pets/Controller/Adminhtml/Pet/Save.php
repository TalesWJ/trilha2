<?php

declare(strict_types=1);

namespace Webjump\Pets\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Api\PetRepositoryInterface;


/**
 * Class Save
 */
class Save extends Action implements HttpPostActionInterface
{
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
     * Save constructor
     *
     * @param Context $context
     * @param RedirectFactory $redirectFactory
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
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->redirectFactory->create();

        return $resultRedirect->setPath('*/*/petkind');
    }
}
