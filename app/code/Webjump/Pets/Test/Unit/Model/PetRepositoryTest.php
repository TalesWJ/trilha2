<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Model\Pet;
use Webjump\Pets\Model\PetRepository;
use Webjump\Pets\Model\ResourceModel\Pet as ResourceModel;
use Webjump\Pets\Model\ResourceModel\Pet\CollectionFactory;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Model\ResourceModel\Pet\Collection;

class PetRepositoryTest extends TestCase
{
    /**
    * @var PetRepository
    */
    private $instance;

    /**
     * @var ResourceModel
     */
    private $resourceModelMock;

    /**
     * @var CollectionFactory
     */
    private $collectionFactoryMock;

    /**
     * @var PetInterfaceFactory
     */
    private $petModelFactoryMock;

    /**
     * @var Pet
     */
    private $petModelMock;

    /**
     * @var SearchResultFactory
     */
    private $resultFactoryMock;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessorMock;

    /**
     * @var $collectionMock
     */
    private $collectionMock;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaMock;

    /**
     * @var SearchResultInterface
     */
    private $searchResultMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->resourceModelMock = $this->createMock(ResourceModel::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessor::class);
        $this->resultFactoryMock = $this->createMock(SearchResultFactory::class);
        $this->petModelMock = $this->createMock(Pet::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->searchCriteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $this->searchResultMock = $this->createMock(SearchResultInterface::class);

        $this->petModelFactoryMock = $this->getMockBuilder(PetInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->collectionFactoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->collectionFactoryMock
            ->expects($this->any())
            ->method('create')
            ->willReturn($this->collectionMock);

    }

    private function setInstance(): void
    {
        $this->instance = new PetRepository(
            $this->resourceModelMock,
            $this->petModelFactoryMock,
            $this->collectionFactoryMock,
            $this->collectionProcessorMock,
            $this->resultFactoryMock
        );
    }

    /**
     * @test
     */
    public function testSaveWithoutException()
    {
        $expectedResult = $this->petModelMock;

        $this->resourceModelMock
            ->expects($this->once())
            ->method('save')
            ->with($this->petModelMock)
            ->willReturn($this->resourceModelMock);

        $result = $this->instance->save($this->petModelMock);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testSaveWithException()
    {
        $this->resourceModelMock
            ->expects($this->once())
            ->method('save')
            ->with($this->petModelMock)
            ->willThrowException(new Exception());

        $this->expectException(CouldNotSaveException::class);
        $this->instance->save($this->petModelMock);
    }

    /**
     * @test
     */
    public function testGetByIdWithoutException()
    {
        $id = 1;

        $this->petModelFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('load')
            ->with($this->petModelMock, $id, $this->petModelMock::ENTITY_ID)
            ->willReturn($this->resourceModelMock);

        $this->petModelMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($id);

        $result = $this->instance->getById($id);
        $this->assertEquals($this->petModelMock, $result);
    }

    /**
     * @test
     */
    public function testGetByIdWithException()
    {
        $id = 1;

        $this->petModelFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('load')
            ->with($this->petModelMock, $id, $this->petModelMock::ENTITY_ID)
            ->willReturn($this->resourceModelMock);

        $this->petModelMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);
        $this->instance->getById($id);
    }

    /**
     * @test
     */
    public function testGetList()
    {
        $collectionResult = [$this->petModelMock];

        $this->resultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResultMock);

        $this->collectionFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionProcessorMock
            ->expects($this->once())
            ->method('process')
            ->with($this->searchCriteriaMock, $this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($collectionResult);


        $this->searchResultMock
            ->expects($this->once())
            ->method('setItems')
            ->with($collectionResult)
            ->willReturn($this->searchResultMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(1);


        $this->searchResultMock
            ->expects($this->once())
            ->method('setTotalCount')
            ->with(1)
            ->willReturn($this->searchResultMock);

        $result = $this->instance->getList($this->searchCriteriaMock);
        $this->assertEquals($this->searchResultMock, $result);
    }

    public function testDeleteWithoutException()
    {
        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn($this->resourceModelMock);

        $this->instance->delete($this->petModelMock);
    }

    public function testDeleteWithException()
    {
        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willThrowException(new Exception());

        $this->expectException(CouldNotDeleteException::class);
        $this->instance->delete($this->petModelMock);
    }

    /**
     * @test
     */
    public function testDeleteByIdWithoutException()
    {
        $id = 1;

        $this->petModelFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('load')
            ->with($this->petModelMock, $id, $this->petModelMock::ENTITY_ID)
            ->willReturn($this->resourceModelMock);

        $this->petModelMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($id);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn($this->resourceModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn($this->resourceModelMock);

        $this->instance->deleteById($id);
    }

    /**
     * @test
     */
    public function testDeleteByIdNoSuchEntityException()
    {
        $id = 1;

        $this->petModelFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('load')
            ->with($this->petModelMock, $id, $this->petModelMock::ENTITY_ID)
            ->willThrowException(new NoSuchEntityException());

        $this->expectException(NoSuchEntityException::class);
        $this->instance->deleteById($id);
    }

    /**
     * @test
     */
    public function testDeleteByIdCouldNotDeleteException()
    {
        $id = 1;

        $this->petModelFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('load')
            ->with($this->petModelMock, $id, $this->petModelMock::ENTITY_ID)
            ->willReturn($this->resourceModelMock);

        $this->petModelMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($id);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn($this->resourceModelMock);

        $this->resourceModelMock
            ->expects($this->once())
            ->method('delete')
            ->willThrowException(new CouldNotDeleteException(__('Could not Delete')));

        $this->expectException(CouldNotDeleteException::class);
        $this->instance->deleteById($id);
    }
}
