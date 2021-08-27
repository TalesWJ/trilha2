<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model\Source;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;
use Webjump\Pets\Model\Source\PetKindDropDown;
use Magento\Framework\Api\Search\SearchResultInterface;

class PetKindDropDownTest extends TestCase
{
    /**
    * @var PetKindDropDown
    */
    private $instance;

    /**
     * @var PetRepositoryInterfaceFactory
     */
    private $petRepositoryFactoryMock;

    /**
     * @var PetRepositoryInterface
     */
    private $petRepositoryMock;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilderMock;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaMock;

    /**
     * @var SearchResultInterface
     */
    private $searchResultMock;

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
        $this->petRepositoryFactoryMock = $this->getMockBuilder(PetRepositoryInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->petKindMock = $this->getMockBuilder(PetInterface::class)
            ->setMethods(['getName', 'getId'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->searchCriteriaBuilderMock = $this->createMock(SearchCriteriaBuilder::class);
        $this->searchCriteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $this->searchResultMock = $this->createMock(SearchResultInterface::class);
    }

    private function setInstance(): void
    {
        $this->instance = new PetKindDropDown(
            $this->petRepositoryFactoryMock,
            $this->searchCriteriaBuilderMock
        );
    }

    /**
     * @test
     */
    public function testGetAllOptions()
    {
        $petKinds = [$this->petKindMock];
        $expectedResult = [
            '0' => [
                'label' => 'Cat',
                'value' => '1'
            ]
        ];

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->searchCriteriaBuilderMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteriaMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getList')
            ->with($this->searchCriteriaMock)
            ->willReturn($this->searchResultMock);

        $this->searchResultMock
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($petKinds);

        $this->petKindMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn('1');

        $this->petKindMock
            ->expects($this->once())
            ->method('getName')
            ->willReturn('Cat');

        $result = $this->instance->getAllOptions();
        $this->assertEquals($expectedResult, $result);
    }
}
