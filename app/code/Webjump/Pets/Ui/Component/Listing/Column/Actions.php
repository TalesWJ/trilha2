<?php

declare(strict_types=1);

namespace Webjump\Pets\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_DELETE = 'pets/pet/delete';
    const URL_PATH_EDIT = 'pets/pet/edit';

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        $dataSource = parent::prepareDataSource($dataSource);
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $name = $item['name'];
            $editUrl = $this->urlBuilder->getUrl(
                static::URL_PATH_EDIT,
                ['entity_id' => $item['entity_id']]
            );

            $deleteUrl = $this->urlBuilder->getUrl(
                static::URL_PATH_DELETE,
                ['entity_id' => $item['entity_id']]
            );

            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $editUrl,
                    'label' => __('Edit')
                ],
                'delete' => [
                    'href' => $deleteUrl,
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete %1', $name),
                        'message' => __('Are you sure you want to delete %1', $name)
                    ],
                    'post' => true
                ]
            ];
        }

        return $dataSource;
    }
}
