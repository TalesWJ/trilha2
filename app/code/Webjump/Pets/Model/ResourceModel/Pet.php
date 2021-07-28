<?php
declare(strict_types=1);

namespace Webjump\Pets\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Webjump\Pets\Api\Data\PetInterface;

class Pet extends AbstractDb
{
    const SCHEMA_NAME = 'pet_table';

    public function _construct()
    {
        $this->_init(static::SCHEMA_NAME, PetInterface::ENTITY_ID);
    }
}
