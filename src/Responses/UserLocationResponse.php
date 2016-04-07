<?php

namespace Devrtips\Soa\Responses;

use League\Fractal;
use Devrtips\Soa\Entities\UserLocationEntity;

class UserLocationResponse extends Fractal\TransformerAbstract
{
    public function transform(UserLocationEntity $location)
    {
        return [
            'uuid' => $location->uuid, 
            'name' => $location->name, 
            'lat' => $location->lat,
            'long' => $location->long,
            'address' => $location->address
        ];
    }
}