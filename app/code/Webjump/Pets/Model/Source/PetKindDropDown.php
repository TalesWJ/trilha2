<?php

namespace Webjump\Pets\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;

class PetKindDropDown extends AbstractSource
{
    /**
     * @var PetRepositoryInterfaceFactory
     */
    private PetRepositoryInterfaceFactory $petRepositoryFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * PetKindDropdown constructor
     *
     * @param PetRepositoryInterfaceFactory $petRepositoryFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PetRepositoryInterfaceFactory $petRepositoryFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->petRepositoryFactory = $petRepositoryFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $petKinds = [];

        /** @var PetRepositoryInterface $petRepository */
        $petRepository = $this->petRepositoryFactory->create();
        $kinds = $petRepository->getList($this->searchCriteriaBuilder->create());
        foreach ($kinds->getItems() as $kind) {
            $petKinds[] = [
                'label' => $kind->getName(),
                'value' => $kind->getId(),
            ];
        }
        return $petKinds;
    }
}
