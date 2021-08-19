<?php

declare(strict_types=1);

namespace Webjump\Pets\Ui\Component\Listing\Column;

use Magento\Framework\Url;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var string
     */
    protected $viewUrl;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Url $urlBuilder
     * @param string $viewUrl
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $urlBuilder,
        $viewUrl = '',
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->viewUrl    = $viewUrl;
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

        foreach ($dataSource['data']['items'] as $item) {
            $name = $item['name'];
            $editUrl = $this->urlBuilder->getUrl(
                'pet/petkind/edit',
                ['entity_id' => $item['entity_id']]
            );

            $deleteUrl = $this->urlBuilder->getUrl(
                'pet/petkind/delete',
                ['entity_id' => $item['entity_id']]
            );

            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $editUrl,
                    'label' => __('Edit'),
                    'hidden' => false,
                    '__disableTmpl' => true
                ],
                'delete' => [
                    'href' => $deleteUrl,
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete %1', $name),
                        'message' => __('Are you sure you want to delete %1', $name)
                    ],
                    'post' => true,
                    '__disableTmpl' => true
                ]
            ];
        }

        return $dataSource;
    }
}
