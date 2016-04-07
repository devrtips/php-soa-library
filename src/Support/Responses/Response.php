<?php

namespace Devrtips\Soa\Support\Responses;

abstract class Response
{
    protected $data = null;
    protected $message = null;
    protected $success;
    protected $httpStatusCode = 200;

    /**
     * Check if response was unsuccessful.
     *
     * @return bool
     */
    public function fails()
    {
        return (bool) !$this->success;
    }

    /**
     * Check if response was successful.
     *
     * @return bool
     */
    public function passes()
    {
        return (bool) $this->success;
    }

    /**
     * Set HTTP response status.
     *
     * @param int $code
     * @return Response $this
     */
    public function withStatus($code)
    {
        $this->httpStatusCode = $code;

        return $this;
    }

    /**
     * Return response message.
     *
     * @return string|null
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Return data or matching key from data.
     *
     * @return mixed
     */
    public function data($key = null)
    {
        if ($key === null) {
            return $this->data;
        }

        return (isset($this->data[$key])) ? $this->data[$key] : null;
    }

    /**
     * Generate json output when response object is converted to string at the end of the request.
     *
     * @return string
     */
    public function __toString()
    {
        http_response_code($this->httpStatusCode);
        header('Content-Type: application/json');

        echo json_encode($this->getOutputFormat());
        exit;
    }

    /**
     * Get result output format.
     *
     * @return array
     */
    abstract protected function getOutputFormat();
}