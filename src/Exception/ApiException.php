<?php

namespace Shufflingpixels\BokioApi\Exception;

use Shufflingpixels\BokioApi\Objects\Error;
use Throwable;

class ApiException extends Exception
{
    protected Error $error;

    public function __construct(Error $error, Throwable|null $previous = null)
    {
        parent::__construct("API Error", 0, $previous);
        $this->error = $error;
    }

    public function getError() : Error
    {
        return $this->error;
    }
}
