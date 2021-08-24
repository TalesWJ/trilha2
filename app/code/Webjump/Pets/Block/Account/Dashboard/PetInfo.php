<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Webjump\Pets\Block\Account\Dashboard;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;

class PetInfo extends Template
{
    /**
     * @var CurrentCustomer
     */
    private CurrentCustomer $currentCustomer;

    private PetRepositoryInterfaceFactory $petRepositoryFactory;

    /**
     * Block constructor
     *
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param PetRepositoryInterfaceFactory $petRepositoryFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CurrentCustomer $currentCustomer,
        PetRepositoryInterfaceFactory $petRepositoryFactory,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->petRepositoryFactory = $petRepositoryFactory;
        parent::__construct($context, $data);
    }

    /**
     * Returns the Magento Customer Model for this block
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Get registered pet name
     *
     * @return string
     */
    public function getPetName(): string
    {
        $customer = $this->getCustomer();
        $attr = $customer->getCustomAttribute('pet_name');
        if (!$attr) {
            return 'No pet name was registered.';
        }
        return $attr->getValue();
    }

    /**
     * Get PetKind
     *
     * @return string
     */
    public function getPetKind(): string
    {
        $customer = $this->getCustomer();
        $attr = $customer->getCustomAttribute('pet_kind');
        if (!$attr) {
            return 'No pet kind was registered.';
        }
        $petRepository = $this->petRepositoryFactory->create();
        $petKind = $petRepository->getById($attr->getValue());
        return $petKind->getName();
    }

    /**
     * Check if display pet is enabled
     *
     * @return bool
     */
    public function isPetDisplayEnabled(): bool
    {
        return $this->_scopeConfig->getValue('display_pets/display/enable');
    }

    /**
     * @inheritdoc
     */
    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }
}
