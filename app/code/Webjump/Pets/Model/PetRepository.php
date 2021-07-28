<?php

namespace Webjump\Pets\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Model\ResourceModel\Pet as ResourceModel;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Model\ResourceModel\Pet\CollectionFactory;
use Webjump\Pets\Api\Data\PetInterfaceFactory;

class PetRepository implements PetRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    protected ResourceModel $resourceModel;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var PetInterfaceFactory
     */
    protected PetInterfaceFactory $petFactory;

    /**
     * @var SearchResultFactory
     */
    protected SearchResultFactory $resultFactory;

    /**
     * @var CollectionProcessor
     */
    private CollectionProcessor $collectionProcessor;

    /**
     * PetRepository constructor.
     * @param ResourceModel $resourceModel
     * @param PetInterfaceFactory $petFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessor $collectionProcessor
     * @param SearchResultFactory $resultFactory
     */
    public function __construct(
        ResourceModel $resourceModel,
        PetInterfaceFactory $petFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessor $collectionProcessor,
        SearchResultFactory $resultFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->petFactory = $petFactory;
        $this->resultFactory = $resultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param PetInterface $pet
     * @return PetInterface
     * @throws CouldNotSaveException
     */
    public function save(PetInterface $pet): PetInterface
    {
        try {
            $this->resourceModel->save($pet);
        } catch (\Exception $e) {
            throw new CouldNotSaveException($e->getMessage());
        }

        return $pet;
    }

    /**
     * @param int $petId
     * @return PetInterface
     */
    public function getById(int $petId): PetInterface
    {
        $pet = $this->petFactory->create();
        $this->resourceModel->load($pet, $petId, PetInterface::ENTITY_ID);

        return $pet;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface
    {
        $searchResult = $this->resultFactory->create();
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

}
