<?php

declare(strict_types=1);

namespace Webjump\Pets\Block\Adminhtml\Pets\Edit;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 */
abstract class GenericButton
{
    /**
     * @var Context
     */
    private Context $context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * Return model ID
     *
     * @return string|null
     */
    public function getModelId(): ?string
    {
        return $this->context->getRequest()->getParam('entity_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
