<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Ui\Component\Listing\Column\Actions;
use Magento\Ui\Component\AbstractComponent;

class ActionsTest extends TestCase
{
    /**
    * @var Actions
    */
    private $instance;

    /**
     * @var ContextInterface
     */
    private $contextMock;

    /**
     * @var UiComponentFactory
     */
    private $uiComponentFactoryMock;

    /**
     * @var UrlInterface
     */
    private $urlMock;

    /**
     * @var AbstractComponent
     */
    private $abstractComponentMock;

    /**
     * @var Column
     */
    private $columnMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(ContextInterface::class);
        $this->columnMock = $this->createMock(Column::class);
        $this->urlMock = $this->createMock(UrlInterface::class);
        $this->abstractComponentMock = $this->createMock(AbstractComponent::class);
        $this->uiComponentFactoryMock = $this->createMock(UiComponentFactory::class);
    }

    private function setInstance(): void
    {
        $this->instance = new Actions(
            $this->contextMock,
            $this->uiComponentFactoryMock,
            $this->urlMock,
            [],
            []
        );
    }

    /**
     * @test
     */
    public function testPrepareDataSourceWithoutItems()
    {
        $dataSource = [];

        $result = $this->instance->prepareDataSource($dataSource);
        $this->assertEquals($dataSource, $result);
    }

    /**
     * @test
     */
    public function testPrepareDataSourceWithItems()
    {
        $dataSource = [
            'data' => [
                'items' => [
                    [
                        'id_field_name' => 'entity_id',
                        'entity_id' => '19',
                        'name' => 'Gato',
                        'description' => 'Felino',
                        'created_at' => '2021-08-23 14:08:41',
                        'orig_data' => null
                    ]
                ]
            ]
        ];

        $this->urlMock
            ->expects($this->exactly(2))
            ->method('getUrl')
            ->withConsecutive(
                ['pets/pet/edit', ['entity_id' => '19']],
                ['pets/pet/delete', ['entity_id' => '19']]
            );

        $this->instance->prepareDataSource($dataSource);
    }
}
