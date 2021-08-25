<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Block\Account\Dashboard;

use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\TemplateInterface;
use PHPUnit\Framework\TestCase;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Webjump\Pets\Api\PetRepositoryInterface;
use Webjump\Pets\Api\PetRepositoryInterfaceFactory;
use Webjump\Pets\Block\Account\Dashboard\PetInfo;
use Webjump\Pets\Api\Data\PetInterface;

/**
 * Unit test for class \Webjump\Pets\Block\Account\Dashboard\PetInfo
 */
class PetInfoTest extends TestCase
{
    /**
     * @var PetInfo
     */
    private $instance;

    /**
     * @var AttributeInterface
     */
    private $attributeMock;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var CustomerInterface
     */
    private $customerMock;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomerMock;

    /**
     * @var PetRepositoryInterfaceFactory
     */
    private $petRepositoryFactoryMock;

    /**
     * @var PetRepositoryInterface
     */
    private $petRepositoryMock;

    /**
     * @var PetInterface
     */
    private $petKindMock;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfigMock;

    /**
     * @var TemplateInterface
     */
    private $templateMock;

    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->currentCustomerMock = $this->createMock(CurrentCustomer::class);
        $this->petRepositoryMock = $this->createMock(PetRepositoryInterface::class);
        $this->petKindMock = $this->createMock(PetInterface::class);
        $this->petRepositoryFactoryMock = $this->getMockBuilder(PetRepositoryInterfaceFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->customerMock = $this->createMock(CustomerInterface::class);
        $this->attributeMock = $this->createMock(AttributeInterface::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $this->templateMock = $this->createMock(TemplateInterface::class);

        $this->contextMock
            ->expects($this->once())
            ->method('getScopeConfig')
            ->willReturn($this->scopeConfigMock);
    }

    private function setInstance(): void
    {
        $this->instance = new PetInfo(
            $this->contextMock,
            $this->currentCustomerMock,
            $this->petRepositoryFactoryMock,
            []
        );
    }

    /**
     * @test
     */
    public function testGetCustomerWithExistingCustomer()
    {
        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($this->customerMock);

        $this->instance->getCustomer();
    }

    /**
     * @test
     */
    public function testGetCustomerThrowingException()
    {
        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willThrowException((new NoSuchEntityException()));

        $this->instance->getCustomer();
    }

    public function testGetPetNameWithRegisteredPet()
    {
        $expectedValue = 'Test';

        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($this->customerMock);

        $this->customerMock
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with('pet_name')
            ->willReturn($this->attributeMock);

        $this->attributeMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('Test');

        $result = $this->instance->getPetName();
        $this->assertEquals($expectedValue, $result);
    }

    /**
     * @test
     */
    public function testGetPetNameWithoutRegisteredPet()
    {
        $expectedValue = 'No pet name was registered.';

        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($this->customerMock);

        $this->customerMock
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with('pet_name')
            ->willReturn(null);

        $result = $this->instance->getPetName();
        $this->assertEquals($expectedValue, $result);
    }

    /**
     * @test
     */
    public function testGetPetKindWithRegisteredCustomer()
    {
        $value = '2';
        $expectedName = 'Cat';

        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($this->customerMock);

        $this->customerMock
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with('pet_kind')
            ->willReturn($this->attributeMock);

        $this->petRepositoryFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petRepositoryMock);

        $this->attributeMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($value);

        $this->petRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($value)
            ->willReturn($this->petKindMock);

        $this->petKindMock
            ->expects($this->once())
            ->method('getName')
            ->willReturn($expectedName);

        $resultName = $this->instance->getPetKind();
        $this->assertEquals($expectedName, $resultName);
    }

    /**
     * @test
     */
    public function testGetPetKindWithoutRegisteredCustomer()
    {
        $expectedResult = 'No pet kind was registered.';

        $this->currentCustomerMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($this->customerMock);

        $this->customerMock
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with('pet_kind')
            ->willReturn(null);

        $result = $this->instance->getPetKind();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function testIsPetDisplayEnabled()
    {
        $this->scopeConfigMock
            ->expects($this->once())
            ->method('getValue')
            ->with('display_pets/display/enable')
            ->willReturn(true);

        $result = $this->instance->isPetDisplayEnabled();
        $this->assertTrue($result);
    }
}
