<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\PetRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Webjump\Pets\Controller\Adminhtml\Pet\Delete;
use Magento\Framework\Controller\Result\Redirect;
use Webjump\Pets\Api\Data\PetInterface;

class DeleteTest extends TestCase
{
    /**
     * @var Delete
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
     * @var ManagerInterface
     */
    private $messageManagerMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->redirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->petKindMock = $this->createMock(PetInterface::class);
        $this->messageManagerMock = $this->createMock(ManagerInterface::class);

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

    }

    private function setInstance(): void
    {
        $this->instance = new Delete(
            $this->contextMock,
            $this->petRepositoryMock
        );
    }

    /**
     * @test
     */
    public function testExecuteWithoutException(): void
    {
        $id = 1;

        $this->redirectFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirectMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($this->petKindMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($this->petKindMock);

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
    public function testExecuteWithException()
    {
        $id = 1;

        $this->redirectFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirectMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($this->petKindMock);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($this->petKindMock)
            ->willThrowException(new CouldNotDeleteException(__('Could not delete pet kind.')));

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('Could not delete the Pet Kind.'));

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
    public function testExecuteNoPetKindIdFound()
    {
        $this->redirectFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirectMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn(null);

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('We could not find the desired Pet Kind.'));

        $this->redirectMock
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturn($this->redirectMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->redirectMock, $result);
    }
}
