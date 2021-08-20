<?php

namespace Webjump\Pets\Api\Data;

/**
 * Interface PetInterface
 * @api
 */
interface PetInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CREATED_AT = 'created_at';

    /**
     * Get ID
     *
     * @return mixed
     */
    public function getEntityId();


    /**
     * Get kind name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get kind description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setCreatedAt(string $value): void;

    /**
     * Set ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId): PetInterface;

    /**
     * Set kind name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): PetInterface;

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): PetInterface;
}
