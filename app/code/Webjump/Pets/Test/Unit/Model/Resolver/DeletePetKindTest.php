<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model\Resolver;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;
use Magento\GraphQl\Model\Query\Resolver\Context;
use Webjump\Pets\Model\Resolver\DeletePetKind;

class DeletePetKindTest extends TestCase
{
    /**
    * @var DeletePetKind
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
     * @var Context
     */
    private $contextMock;

    /**
     * @var ResolveInfo
     */
    private $resolveInfoMock;

    /**
     * @var Field
     */
    private $fieldMock;

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

        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->contextMock = $this->createMock(Context::class);
        $this->fieldMock = $this->createMock(Field::class);
        $this->resolveInfoMock = $this->createMock(ResolveInfo::class);

    }

    private function setInstance(): void
    {
        $this->instance = new DeletePetKind(
            $this->petRepositoryFactoryMock
        );
    }

    /**
     * @test
     */
    public function testResolveWithArgsSuccess()
    {
        $args = [
            'entity_id' => 1
        ];

        $expectedResult = [
            'message' => 'PetKind deleted with success.'
        ];

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($args['entity_id']);

        $result = $this->instance->resolve(
            $this->fieldMock,
            $this->contextMock,
            $this->resolveInfoMock,
            [],
            $args
        );
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testResolveWithArgsFailureCouldNotDelete()
    {
        $args = [
            'entity_id' => 1
        ];

        $expectedResult = [
            'message' => __('Could not delete.')
        ];

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($args['entity_id'])
            ->willThrowException(new CouldNotDeleteException(__('Could not delete.')));

        $result = $this->instance->resolve(
            $this->fieldMock,
            $this->contextMock,
            $this->resolveInfoMock,
            [],
            $args
        );
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testResolveWithArgsFailureNoSuchEntity()
    {
        $args = [
            'entity_id' => 1
        ];

        $expectedResult = [
            'message' => __('No Such entity.')
        ];

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($args['entity_id'])
            ->willThrowException(new NoSuchEntityException(__('No Such entity.')));

        $result = $this->instance->resolve(
            $this->fieldMock,
            $this->contextMock,
            $this->resolveInfoMock,
            [],
            $args
        );
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testResolveWithoutArgs()
    {
        $args = [];

        $this->expectException(GraphQlInputException::class);

        $result = $this->instance->resolve(
            $this->fieldMock,
            $this->contextMock,
            $this->resolveInfoMock,
            [],
            $args
        );
    }
}
