<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;
use Magento\GraphQl\Model\Query\Resolver\Context;
use Webjump\Pets\Model\Resolver\CreatePetKind;

class CreatePetKindTest extends TestCase
{
    /**
    * @var CreatePetKind
    */
    private $instance;

    /**
     * @var PetRepositoryInterfaceFactory
     */
    private $petRepositoryFactoryMock;

    /**
     * @var PetInterfaceFactory
     */
    private $petFactoryMock;

    /**
     * @var PetInterface
     */
    private $petKindMock;

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

    /**
     * @var GraphQlInputException
     */
    private $exceptionMock;

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

        $this->petFactoryMock = $this->getMockBuilder(PetInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->petKindMock = $this->getMockBuilder(PetInterface::class)
            ->setMethods(['setData'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->contextMock = $this->createMock(Context::class);
        $this->fieldMock = $this->createMock(Field::class);
        $this->resolveInfoMock = $this->createMock(ResolveInfo::class);
    }

    private function setInstance(): void
    {
        $this->instance = new CreatePetKind(
            $this->petRepositoryFactoryMock,
            $this->petFactoryMock
        );
    }

    /**
     * @test
     */
    public function testResolveWithArgs()
    {
        $args = [
            'input' => [
                'name' => 'Duck',
                'description' => 'Flies and swims'
            ]
        ];

        $expectedResult = [
            'petkind' => $this->petKindMock
        ];

        $this->petFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKindMock);

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->petKindMock
            ->expects($this->once())
            ->method('setData')
            ->with($args['input'])
            ->willReturn($this->petKindMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindMock)
            ->willReturn($this->petKindMock);

        $result = $this->instance->resolve(
            $this->fieldMock,
            $this->contextMock,
            $this->resolveInfoMock,
            [],
            $args
        );
        $this->assertEquals($expectedResult, $result);
    }

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
