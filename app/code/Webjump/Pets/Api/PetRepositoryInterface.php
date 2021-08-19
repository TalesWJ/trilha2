<?php

namespace Webjump\Pets\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Webjump\Pets\Api\Data\PetInterface;

/**
 * Interface ExampleInterface
 * @api
 * @package Webjump\ApiExample\Api
 */
interface PetRepositoryInterface
{
    /**
     * Create or update a customer.
     *
     * @param PetInterface $pet
     * @return PetInterface
     */
    public function save(PetInterface $pet): PetInterface;

    /**
     * Get a pet by Pet ID.
     *
     * @param int $petId
     * @return PetInterface
     */
    public function getById(int $petId): PetInterface;

    /**
     * Retrieve Pets which match a specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface;

    /**
     * Delete Pet Kind
     *
     * @param PetInterface $pet
     */
    public function delete(PetInterface $pet): void;
}
