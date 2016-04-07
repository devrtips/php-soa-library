<?php

namespace Devrtips\Soa\Support\Responses;

use Devrtips\Soa\Support\Lang;

class Error extends Response
{
    protected $success = false;

    public function __construct($message, array $data = [])
    {
        $this->message = $message;
        $this->data = $data;
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