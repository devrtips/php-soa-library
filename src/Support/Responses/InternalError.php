<?php

namespace Devrtips\Soa\Support\Responses;

use Devrtips\Soa\Support\Lang;

class InternalError extends Error
{
    protected $internalError;

    public function __construct($message, $internalError)
    {
        parent::__construct($message, []);

        $this->internalError = $internalError;
        $this->logInternalError();
    }

    protected function logInternalError()
    {
        error_log(Lang::trans($this->message) . ' - ' . $this->internalError);
    }
}