<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Block\Adminhtml\Pets\Edit;

use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Block\Adminhtml\Pets\Edit\SaveButton;

class SaveButtonTest extends TestCase
{
    /**
     * @var SaveButton
     */
    private $instance;

    /**
     * @var Context
     */
    private $contextMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
    }

    private function setInstance(): void
    {
        $this->instance = new SaveButton($this->contextMock);
    }

    public function testGetButtonData()
    {
        $expectedResult = [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ]
        ];

        $result = $this->instance->getButtonData();
        $this->assertEquals($expectedResult, $result);
    }
}
