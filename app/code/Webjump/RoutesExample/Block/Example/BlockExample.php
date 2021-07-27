<?php

namespace Webjump\RoutesExample\Block\Example;

use Magento\Contact\Block\ContactForm;

class BlockExample extends ContactForm
{
    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return [
            'Tenis',
            'Camisa',
            'Chinelo',
            'Calça'
        ];
    }
}
