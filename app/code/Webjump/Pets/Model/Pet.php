<?php

namespace Webjump\Pets\Model;

use Magento\Framework\Model\AbstractModel;
use Webjump\Pets\Model\ResourceModel\Pet as ResourceModel;
use Webjump\Pets\Api\Data\PetInterface;

class Pet extends AbstractModel implements PetInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return (int)$this->getData(static::ENTITY_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId(int $id): self
    {
        $this->setData(static::ENTITY_ID, $id);
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return (int)$this->getData(static::OWNER_ID);
    }

    /**
     * @return string
     */
    public function getPetName(): string
    {
        return (string)$this->getData(static::PETNAME);
    }

    /**
     * @return string
     */
    public function getPetOwner(): string
    {
        return (string)$this->getData(static::PETOWNER);
    }

    /**
     * @return string
     */
    public function getOwnerTelephone(): string
    {
        return (string)$this->getData(static::OWNERTELEPHONE);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (string)$this->getData(static::CREATED_AT);
    }

    /**
     * @param string $value
     */
    public function setCreatedAt(string $value): void
    {
        $this->setData(static::CREATED_AT, $value);
    }

    /**
     * @param int $id
     * @return PetInterface
     */
    public function setOwnerId(int $id): PetInterface
    {
        $this->setData(static::OWNER_ID, $id);
        return $this;
    }

    /**
     * @param string $petName
     * @return PetInterface|$this
     */
    public function setPetName(string $petName): PetInterface
    {
        $this->setData(static::PETNAME, $petName);
        return $this;
    }

    /**
     * @param string $petOwner
     * @return PetInterface|$this
     */
    public function setPetOwner(string $petOwner): PetInterface
    {
        $this->setData(static::PETOWNER, $petOwner);
        return $this;
    }

    /**
     * @param string $ownerTelephone
     * @return PetInterface|$this
     */
    public function setOwnerTelephone(string $ownerTelephone): PetInterface
    {
        $this->setData(static::OWNERTELEPHONE, $ownerTelephone);
        return $this;
    }

}
