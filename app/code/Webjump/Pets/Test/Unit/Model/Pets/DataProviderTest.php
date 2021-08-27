<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model\Pets;

use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Model\Pets\DataProvider;
use Webjump\Pets\Model\ResourceModel\Pet\CollectionFactory;
use Webjump\Pets\Model\ResourceModel\Pet\Collection;
use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    /**
    * @var DataProvider
    */
    private $instance;

    /**
     * @var Collection
     */
    private $collectionMock;

    /**
     * @var CollectionFactory
     */
    private $collectionFactoryMock;

    /**
     * @var PetInterface
     */
    private $petKindMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->collectionMock = $this->getMockBuilder(Collection::class)
            ->setMethods(['getItems'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->petKindMock = $this->getMockBuilder(PetInterface::class)
            ->setMethods(['getData', 'getId'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->collectionFactoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->collectionFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

    }

    private function setInstance(): void
    {
        $this->instance = new DataProvider(
            '',
            '',
            '',
            $this->collectionFactoryMock
        );
    }

    /**
     * @test
     */
    public function testGetData()
    {
        $items = [$this->petKindMock];
        $loadedData = [
            '19' => [
                [
                    'entity_id' => '19',
                    'name' => 'Gato',
                    'description' => 'Felino',
                    'created_at' => '2021-08-23 14:08:41'
                ]
            ]
        ];

        $this->collectionMock
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($items);

        $this->petKindMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn('19');

        $this->petKindMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn($loadedData['19']);

        $result = $this->instance->getData();
        $this->assertEquals($loadedData, $result);

        $result = $this->instance->getData();
        $this->assertEquals($loadedData, $result);
    }

}
