<?php

namespace Devrtips\Soa;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class BaseService
{
    const ERR_VALIDATION = 'validation.error';
    const ERR_EXCEPTION = 'exception.error';
    const ERR_SERVICE_FAILURE = 'exception.error';

    protected function transform($items, $callback)
    {
        $fractal = new Manager();
        $resource = new Collection($items, $callback);

        return $fractal->createData($resource)->toArray()['data'];
    }

    protected function transformItem($item, $callback)
    {
        $fractal = new Manager();
        $resource = new Item($item, $callback);

        return $fractal->createData($resource)->toArray()['data'];
    }
}
