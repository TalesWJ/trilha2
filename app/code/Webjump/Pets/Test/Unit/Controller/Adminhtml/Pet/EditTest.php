<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Api\PetRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Page\Title;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Webjump\Pets\Api\Data\PetInterface;
use Webjump\Pets\Controller\Adminhtml\Pet\Edit;
use Magento\Framework\View\Page\Config;

class EditTest extends TestCase
{
    /**
     * @var Edit
     */
    private $instance;

    /**
     * @var ResultFactory
     */
    private $resultFactoryMock;

    /**
     * @var ResultInterface
     */
    private $resultMock;

    /**
     * @var PetRepositoryInterface
     */
    private $petRepositoryMock;

    /**
     * @var Config
     */
    private $configMock;

    /**
     * @var Title
     */
    private $titleMock;
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
        $this->resultMock = $this->getMockBuilder(ResultInterface::class)
            ->addMethods(['setActiveMenu', 'getConfig'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->resultFactoryMock = $this->createMock(ResultFactory::class);
        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->petKindMock = $this->createMock(PetInterface::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->redirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->messageManagerMock = $this->createMock(ManagerInterface::class);
        $this->configMock = $this->createMock(Config::class);
        $this->titleMock = $this->createMock(Title::class);

        $this->contextMock
            ->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);

        $this->contextMock
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);

        $this->contextMock
            ->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManagerMock);

        $this->contextMock
            ->expects($this->once())
            ->method('getResultRedirectFactory')
            ->willReturn($this->redirectFactoryMock);
    }

    private function setInstance(): void
    {
        $this->instance = new Edit(
            $this->contextMock,
            $this->petRepositoryMock
        );
    }

    /**
     * @test
     */
    public function testExecuteWithoutId(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn(null);

        $this->resultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->resultFactoryMock::TYPE_PAGE)
            ->willReturn($this->resultMock);

        $this->resultMock
            ->expects($this->once())
            ->method('setActiveMenu')
            ->with('Webjump_Pets::webjumppets');

        $this->resultMock
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->configMock);

        $this->configMock
            ->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->titleMock);

        $this->titleMock
            ->expects($this->once())
            ->method('prepend')
            ->with(__('Pet Kind'))
            ->willReturn($this->resultMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->resultMock, $result);
    }

    /**
     * @test
     */
    public function testExecuteWithId(): void
    {
        $id = 2;

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

        $this->resultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->resultFactoryMock::TYPE_PAGE)
            ->willReturn($this->resultMock);

        $this->resultMock
            ->expects($this->once())
            ->method('setActiveMenu')
            ->with('Webjump_Pets::webjumppets');

        $this->resultMock
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->configMock);

        $this->configMock
            ->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->titleMock);

        $this->titleMock
            ->expects($this->once())
            ->method('prepend')
            ->with(__('Pet Kind'))
            ->willReturn($this->resultMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->resultMock, $result);
    }

    /**
     * @test
     */
    public function testExecuteThrowingException(): void
    {
        $id = 2;

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willThrowException(new NoSuchEntityException());

        $this->messageManagerMock
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('No such entity.'));

        $this->redirectFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with()
            ->willReturn($this->redirectMock);

        $this->redirectMock
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturn($this->resultMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->resultMock, $result);
    }

}
