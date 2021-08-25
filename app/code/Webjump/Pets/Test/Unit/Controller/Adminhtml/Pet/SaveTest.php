<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\PetRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Api\Data\PetInterfaceFactory;
use Webjump\Pets\Controller\Adminhtml\Pet\Save;

class SaveTest extends TestCase
{
    /**
     * @var Save
     */
    private $instance;

    /**
     * @var PetRepositoryInterface
     */
    private $petRepositoryMock;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var RedirectFactory
     */
    private $redirectFactoryMock;

    /**
     * @var Redirect
     */
    private $redirectMock;

    /**
     * @var RequestInterface
     */
    private $requestMock;

    /**
     * @var PetInterface
     */
    private $petKindMock;

    /**
     * @var PetInterfaceFactory
     */
    private $petKindFactoryMock;

    /**
     * @var ManagerInterface
     */
    private $messageManagerMock;

    /**
     * @var Int
     */
    private $id;

    /**
     * @var array
     */
    private $parameters;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->id = 2;
        $this->parameters = [];

        $this->contextMock = $this->createMock(Context::class);
        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->redirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->messageManagerMock = $this->createMock(ManagerInterface::class);

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->setMethods(['getPostValue', 'getParam'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->petKindMock = $this->getMockBuilder(PetInterface::class)
            ->setMethods(['setData'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->petKindFactoryMock = $this->getMockBuilder(PetInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->contextMock
            ->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->redirectFactoryMock);

        $this->contextMock
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);

        $this->contextMock
            ->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);

        $this->redirectFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirectMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getPostValue')
            ->willReturn($this->parameters);

        $this->petKindFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKindMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($this->id);
    }

    private function setInstance(): void
    {
        $this->instance = new Save(
            $this->contextMock,
            $this->redirectFactoryMock,
            $this->petRepositoryMock,
            $this->petKindFactoryMock
        );
    }

    /**
     * @test
     */
    public function testExecuteWithId()
    {
        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($this->id)
            ->willReturn($this->petKindMock);

        $this->petKindMock
            ->expects($this->once())
            ->method('setData')
            ->with($this->parameters)
            ->willReturn($this->petKindMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindMock)
            ->willReturn($this->petKindMock);

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addSuccessMessage')
            ->with(__('Success! Pet Kind was saved with no errors.'));

        $this->redirectMock
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturn($this->redirectMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->redirectMock, $result);
    }

    /**
     * @test
     */
    public function testExecuteWithIdAndNoSuchEntityException()
    {
        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($this->id)
            ->willThrowException(new NoSuchEntityException());

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('This PetKind does not exist.'));

        $this->redirectMock
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturn($this->redirectMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->redirectMock, $result);
    }

    /**
     * @test
     */
    public function testExecuteWithIdAndCouldNotSaveException()
    {
        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($this->id)
            ->willReturn($this->petKindMock);

        $this->petKindMock
            ->expects($this->once())
            ->method('setData')
            ->with($this->parameters)
            ->willReturn($this->petKindMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindMock)
            ->willThrowException(new CouldNotSaveException(__('Could not save Pet Kind.')));

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('Something went wrong when saving the Pet Kind'));

        $this->redirectMock
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturn($this->redirectMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->redirectMock, $result);
    }
}
