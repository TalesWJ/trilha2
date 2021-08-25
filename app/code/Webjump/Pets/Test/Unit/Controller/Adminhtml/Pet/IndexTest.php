<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Controller\Adminhtml\Pet;

use Magento\Backend\App\Action\Context;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Controller\Adminhtml\Pet\Index;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Page\Config;

class IndexTest extends TestCase
{
    /**
     * @var Index
     */
    private $instance;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var PageFactory
     */
    private $pageFactoryMock;

    /**
     * @var Page
     */
    private $pageMock;

    /**
     * @var Title
     */
    private $titleMock;

    /**
     * @var Config
     */
    private $configMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->pageFactoryMock = $this->createMock(PageFactory::class);
        $this->pageMock = $this->createMock(Page::class);
        $this->titleMock = $this->createMock(Title::class);
        $this->configMock = $this->createMock(Config::class);
    }

    private function setInstance(): void
    {
        $this->instance = new Index(
            $this->contextMock,
            $this->pageFactoryMock
        );
    }

    public function testExecute()
    {
        $this->pageFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->pageMock);

        $this->pageMock
            ->expects($this->once())
            ->method('setActiveMenu')
            ->with('Webjump_Pets::webjumppets');

        $this->pageMock
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
            ->willReturn($this->pageMock);

        $result = $this->instance->execute();
        $this->assertEquals($this->pageMock, $result);
    }
}
