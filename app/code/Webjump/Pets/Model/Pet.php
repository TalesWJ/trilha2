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
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->getData(static::ENTITY_ID);
    }

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId): self
    {
        $this->setData(static::ENTITY_ID, $entityId);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->getData(static::NAME);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->getData(static::DESCRIPTION);
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
     * @param string $name
     * @return PetInterface|$this
     */
    public function setName(string $name): PetInterface
    {
        $this->setData(static::NAME, $name);
        return $this;
    }

    /**
     * @param string $description
     * @return PetInterface|$this
     */
    public function setDescription(string $description): PetInterface
    {
        $this->setData(static::DESCRIPTION, $description);
        return $this;
    }

}
