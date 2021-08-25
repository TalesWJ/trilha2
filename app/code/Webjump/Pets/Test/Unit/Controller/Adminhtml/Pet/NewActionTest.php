<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Controller\Adminhtml\Pet;

use PHPUnit\Framework\TestCase;
use Webjump\Pets\Controller\Adminhtml\Pet\NewAction;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;

class NewActionTest extends TestCase
{
    /**
    * @var NewAction
    */
    private $instance;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var ResultInterface
     */
    private $resultMock;

    /**
     * @var ResultFactory
     */
    private $resultFactoryMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->resultMock = $this->getMockBuilder(ResultInterface::class)
            ->addMethods(['forward'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->resultFactoryMock = $this->createMock(ResultFactory::class);

        $this->contextMock
            ->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);
    }

    private function setInstance(): void
    {
        $this->instance = new NewAction($this->contextMock);
    }

    /**
     * @test
     */
    public function testExecute()
    {
        $this->resultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->resultFactoryMock::TYPE_FORWARD)
            ->willReturn($this->resultMock);

        $this->resultMock
            ->expects($this->once())
            ->method('forward')
            ->with('edit')
            ->willReturn($this->resultMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->resultMock, $result);
    }
}
