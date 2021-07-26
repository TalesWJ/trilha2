<?php

namespace Webjump\ApiExample\Model\Data;

use Webjump\ApiExample\Api\Data\ExampleDataInterface;

class Data implements ExampleDataInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
