<?php
declare(strict_types=1);

namespace Webjump\Pets\Model\ResourceModel\Pet;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Webjump\Pets\Model\ResourceModel\Pet as ResourceModel;
use Webjump\Pets\Model\Pet as Model;

/**
 * Class Collection
 * @package Webjump\Pets\Model\ResourceModel\Pet
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
