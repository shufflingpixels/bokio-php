<?php

namespace Shufflingpixels\BokioApi;

class Auth
{
    protected string $id;

    protected string $token;

    public function __construct(string $id, string $token)
    {
        $this->setId($id);
        $this->setToken($token);
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function setId(string $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function setToken(string $token) : self
    {
        $this->token = $token;
        return $this;
    }
}
