<?php

namespace Webjump\ApiExample\Api\Data;

/**
 * Interface ExampleDataInterface
 * @api
 * @package Webjump\ApiExample\Api\Data
 */
interface ExampleDataInterface
{
    /**
     * @return string
     */
    public function getName():string;

    /**
     * @return string
     */
    public function getLastName():string;

    /**
     * @param string $name
     */
    public function setName(string $name):void;

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName):void;
}
