<?php

namespace Devrtips\Soa\Support\Responses;

use Devrtips\Soa\Support\Lang;

class Success extends Response
{
    protected $success = true;

    public function __construct($data, $message = null)
    {
        $this->data = $data;
        $this->message = $message;
    }

    protected function getOutputFormat()
    {
        return [
            'success' => (bool) $this->success,
            'data' => $this->data,
            'message' => Lang::trans($this->message)
        ];
    }
}
