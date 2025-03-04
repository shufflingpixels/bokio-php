<?php

namespace Shufflingpixels\BokioApi\Objects;

use Psr\Http\Message\ResponseInterface;

class Error
{
    protected ?string $code;

    protected ?string $innerCode;

    protected ?string $bokioErrorId;

    protected ?string $message;

    public function __construct(?string $code, ?string $innerCode, ?string $bokioErrorId, ?string $message)
    {
        $this->code = $code;
        $this->innerCode = $innerCode;
        $this->bokioErrorId = $bokioErrorId;
        $this->message = $message;
    }

    public function getCode() : ?string
    {
        return $this->code;
    }

    public function getInnerCode() : ?string
    {
        return $this->innerCode;
    }

    public function getBokioErrorId() : ?string
    {
        return $this->bokioErrorId;
    }

    public function getMessage() : ?string
    {
        return $this->message;
    }

    public static function fromResponse(ResponseInterface $response) : self
    {
        $data = json_decode($response->getBody());
        return new self($data->code, $data->innerCode, $data->bokioErrorId, $data->message);
    }
}
