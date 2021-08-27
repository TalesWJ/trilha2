<?php

declare(strict_types=1);

namespace Webjump\Pets\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Webjump\Pets\Model\Pet;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PetTest extends TestCase
{
    /**
    * @var Pet
    */
    private $instance;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var Registry
     */
    private $registryMock;


    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    private function setMocks(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->registryMock = $this->createMock(Registry::class);
    }

    private function setInstance(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->instance = $this->objectManager->getObject(
            Pet::class,
            [
                $this->contextMock,
                $this->registryMock
            ]
        );
    }

    /**
     * @test
     */
    public function testSetGetEntityId()
    {
        $id = 2;
        $this->instance->setEntityId($id);
        $result = $this->instance->getEntityId();
        $this->assertEquals($id, $result);
    }

    /**
     * @test
     */
    public function testSetGetDescription()
    {
        $description = 'test';
        $this->instance->setDescription($description);
        $result = $this->instance->getDescription();
        $this->assertEquals($description, $result);
    }

    /**
     * @test
     */
    public function testSetGetName()
    {
        $name = 'test';
        $this->instance->setName($name);
        $result = $this->instance->getName();
        $this->assertEquals($name, $result);
    }

    /**
     * @test
     */
    public function testSetGetCreatedAt()
    {
        $createdAt = '2021-08-21 10:00:00';
        $this->instance->setCreatedAt($createdAt);
        $result = $this->instance->getCreatedAt();
        $this->assertEquals($createdAt, $result);
    }

}
