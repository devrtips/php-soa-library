<?php

namespace Devrtips\Soa;

use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    protected $reqData = [];

    public function __construct()
    {
        $this->reqData = app('request')->json()->all();
    }
}
