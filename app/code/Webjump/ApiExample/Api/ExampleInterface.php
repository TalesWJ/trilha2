<?php

namespace Webjump\ApiExample\Api;

use Webjump\ApiExample\Api\Data\ExampleDataInterface;

/**
 * Interface ExampleInterface
 * @api
 * @package Webjump\ApiExample\Api
 */
interface ExampleInterface
{
    /**
     * @param string $atr
     * @return string
     */
    public function getEndpoint(string $atr):string;

    /**
     * @param ExampleDataInterface $data
     * @return ExampleDataInterface
     */
    public function postEndpoint(ExampleDataInterface $data):string;

}
