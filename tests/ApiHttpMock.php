<?php

namespace Tests;

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Shufflingpixels\BokioApi\Auth;
use Shufflingpixels\BokioApi\Client;

class ApiHttpMock implements ClientInterface
{
    const AUTH_ID = 'auth-customer-id-4084-9c22-de678b66d8e8';
    const AUTH_TOKEN = 'auth-token-90a0ec17-f07e-437c-ac25-4ee6f4651b6c';

    public Auth $auth;

    public Request $request;

    public Response $response;

    public function __construct(public TestCase $testCase)
    {
        $this->auth = new Auth(self::AUTH_ID, self::AUTH_TOKEN);
    }

    public function request(string $method = "GET", string $uri = "/", ?string $body = null) : self
    {
        $uri = sprintf('/companies/%s/%s', $this->auth->getId(), $uri);

        $this->request = new Request($method, $uri, [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => sprintf('Bearer %s', self::AUTH_TOKEN)
        ], $body);
        return $this;
    }

    public function requestFromFile(string $method = "GET", string $uri = "/", $file) : self
    {
        $body = file_get_contents(__DIR__ . "/Fixtures/$file");

        return $this->request($method, $uri, $body);
    }

    public function response(int $status = 200, ?string $body = null) : self
    {
        $this->response = new Response($status, [
            'Content-Type' => 'application/json',
        ], $body);
        return $this;
    }

    public function responseFromFile($file, int $status = 200) : self
    {
        $body = file_get_contents(__DIR__ . "/Fixtures/$file");
        if ($body === false) {
            throw new Exception("failed to load fixture");
        }
        return $this->response($status, $body);
    }

    public function create() : Client
    {
        return new Client($this, $this->auth);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        // Assert method
        $this->testCase->assertEquals($this->request->getUri(), $request->getUri());
        $this->testCase->assertEquals($this->request->getHeaders(), $request->getHeaders());

        $expectedBody = json_decode($this->request->getBody());
        $actualBody = json_decode($request->getBody());

        $this->testCase->assertEquals($expectedBody, $actualBody);
        return $this->response;
    }
}
