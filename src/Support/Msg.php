<?php

namespace Devrtips\Soa\Support;

use Devrtips\Soa\Support\Responses\Error;
use Devrtips\Soa\Support\Responses\InternalError;
use Devrtips\Soa\Support\Responses\Success;

class Msg
{
    public static function success($data, $message = null)
    {
        return new Success($data, $message);
    }

    public static function error($message, $data = [])
    {
        return new Error($message, $data);
    }

    public static function internalError($message, $internalError = null)
    {
        return new InternalError($message, $internalError);
    }
}