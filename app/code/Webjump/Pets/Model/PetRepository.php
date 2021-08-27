<?php

declare(strict_types=1);

namespace Webjump\Pets\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
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
            throw new CouldNotSaveException(__('Could not save Pet Kind.'));
        }
        return $pet;
    }

    /**
     * @param int $petId
     * @return PetInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $petId): PetInterface
    {
        $pet = $this->petFactory->create();
        $this->resourceModel->load($pet, $petId, PetInterface::ENTITY_ID);
        if (!$pet->getId()) {
            throw new NoSuchEntityException(__('The Pet Kind with the "%1" ID doesn\'t exist.', $petId));
        }
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

    /**
     * Delete method in repository
     *
     * @param PetInterface $pet
     * @throws CouldNotDeleteException
     */
    public function delete(PetInterface $pet): void
    {
        try {
            $this->resourceModel->delete($pet);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete pet kind.'));
        }
    }

    /**
     * Delete by ID
     *
     * @param int $petId
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     * @return void
     */
    public function deleteById(int $petId): void
    {
        try {
            $pet = $this->getById($petId);
            try {
                $this->delete($pet);
            } catch (CouldNotDeleteException $delete) {
                throw new CouldNotDeleteException(__($delete->getMessage()));
            }
        } catch (NoSuchEntityException $noSuchEntityException) {
            throw new NoSuchEntityException(__($noSuchEntityException->getMessage()));
        }
    }

}
