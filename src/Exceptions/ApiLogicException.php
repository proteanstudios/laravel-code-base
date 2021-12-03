<?php

namespace Pros\CodeBase\Exceptions;

use Exception;

class ApiLogicException extends Exception
{
    protected $status = 'ERR';

    public function __construct($message, $status = 'ERR', $code = 401)
    {
        $this->status = $status;
        parent::__construct(message: $message, code: $code);
    }

    public function getStatus()
    {
        return $this->status;
    }
}
