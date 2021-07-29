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
    const OWNER_ID = 'owner_id';
    const PETNAME = 'pet_name';
    const PETOWNER = 'pet_owner';
    const OWNERTELEPHONE = 'owner_telephone';
    const CREATED_AT = 'created_at';

    /**
     * Get ID
     *
     * @return int
     */
    public function getPetId(): int;

    /**
     * Get owner ID
     *
     * @return int
     */
    public function getOwnerId(): int;

    /**
     * Get pet name
     *
     * @return string
     */
    public function getPetName(): string;

    /**
     * Get pet owner
     *
     * @return string
     */
    public function getPetOwner(): string;

    /**
     * Get owner telephone
     *
     * @return string
     */
    public function getOwnerTelephone(): string;

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
     * @param int $id
     * @return $this
     */
    public function setPetId(int $id): PetInterface;

    /**
     * Set Owner ID
     *
     * @param int $id
     * @return PetInterface
     */
    public function setOwnerId(int $id): PetInterface;

    /**
     * Set pet name
     *
     * @param string $petName
     * @return $this
     */
    public function setPetName(string $petName): PetInterface;

    /**
     * Set pet owner
     *
     * @param string $petOwner
     * @return $this
     */
    public function setPetOwner(string $petOwner): PetInterface;

    /**
     * Set owner telephone
     *
     * @param string $ownerTelephone
     * @return $this
     */
    public function setOwnerTelephone(string $ownerTelephone): PetInterface;
}
