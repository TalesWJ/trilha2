<?php
/**
 * Importante esse DataProvider estar em Model.
 */

declare(strict_types=1);

namespace Webjump\Pets\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Webjump\Pets\Model\ResourceModel\Pet\CollectionFactory;
use Webjump\Pets\Model\ResourceModel\Pet\Collection;
use Webjump\Pets\Model\Pet;

/**
 * DataProvider Class
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private array $loadedData;

    /**
     * DataProvider's constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var Pet $petkind */
        foreach ($items as $petKind) {
            $this->loadedData[$petKind->getId()] = $petKind->getData();
        }

        return $this->loadedData;
    }
}
