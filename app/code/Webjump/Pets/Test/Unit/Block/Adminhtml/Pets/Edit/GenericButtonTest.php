<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Block\Adminhtml\Pets\Edit;

use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;
use Webjump\Pets\Block\Adminhtml\Pets\Edit\GenericButton;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButtonTest extends TestCase
{
    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var GenericButton
     */
    private $genericButtonMock;

    /**
     * @var RequestInterface
     */
    private $requestMock;

    /**
     * @var UrlInterface
     */
    private $urlMock;

    protected function setUp(): void
    {
        $this->setMocks();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->urlMock = $this->createMock(UrlInterface::class);
        // Abstract Class Mock
        $arguments['context'] = $this->contextMock;
        $this->genericButtonMock = $this->getMockForAbstractClass(
            GenericButton::class,
            $arguments);

    }

    /**
     * @test
     */
    public function testGetModelId()
    {
        $expectedResult = 'Test';

        $this->contextMock
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn('Test');

        $result = $this->genericButtonMock->getModelId();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testGetUrl()
    {
        $route = '';
        $params = [];
        $urlResult = 'URL';

        $this->urlMock
            ->expects($this->once())
            ->method('getUrl')
            ->with($route, $params)
            ->willReturn($urlResult);

        $this->contextMock
            ->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($this->urlMock);

        $result = $this->genericButtonMock->getUrl();
        $this->assertEquals($urlResult, $result);
    }

}

