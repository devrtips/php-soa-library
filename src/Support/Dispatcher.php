<?php

namespace Devrtips\Soa\Support;

use Exception;
use Devrtips\Soa\BaseService;
use Devrtips\Soa\Exceptions\ServiceFailureException;
use Devrtips\Soa\Support\Msg;
use Devrtips\Soa\Support\Responses\Response;

class Dispatcher
{
    public static function call(
        string $serviceClass, 
        string $action, 
        array $data
    )
    {
        $service = new $serviceClass; 

        if (!$service instanceof BaseService) {
            // Throw exception
        }

        if (!method_exists($service, $action)) {
            // Throw exception
        }

        // Prepare data for service action
        $data = new Data($data);

        try {
            return $service->{$action}($data);
        } catch (ServiceFailureException $e) {
            return Msg::error($serviceClass::ERR_SERVICE_FAILURE);
        } catch (Exception $e) {
            return Msg::internalError($serviceClass::ERR_EXCEPTION, $e->getMessage());
        }
    }

    public static function callOrFail(
        string $serviceClass, 
        string $action, 
        array $data
    )
    {
        $res = self::call($serviceClass, $action, $data);

        if ($res->fails()) {
            throw new ServiceFailureException;
        }

        return $res;
    }
}