<?php

namespace Webjump\ApiExample\Model;

use Webjump\ApiExample\Api\Data\ExampleDataInterface;
use Webjump\ApiExample\Api\ExampleInterface;

class Example implements ExampleInterface
{
    /**
     * @param string $atr
     * @return string
     */
    public function getEndpoint(string $atr): string
    {
        $data = json_encode([
           'message' => 'success webapi ['.$atr.']'
        ]);
        return $data;
    }

    /**
     * @param ExampleDataInterface $data
     * @return ExampleDataInterface
     */
    public function postEndpoint(ExampleDataInterface $data): string
    {
        return json_encode([
            'message' => 'success webapi ['.$data->getName().' '.$data->getLastName().']'
        ]);
    }
}
