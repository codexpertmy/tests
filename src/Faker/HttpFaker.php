<?php

namespace Codexpert\Faker;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class HttpFaker
{
    /**
     * @var mixed
     */
    protected $client;

    /**
     * @var mixed
     */
    protected $endpoint;

    /**
     * @var mixed
     */
    protected $expectedJsonResponse;

    /**
     * @var mixed
     */
    protected $expectedPlainResponse;

    /**
     * @var mixed
     */
    protected $expectedResponseHeaders = [];

    /**
     * @var mixed
     */
    protected $mock;

    public static function create(): self
    {
        return new static();
    }

    /**
     * @param int     $status
     * @param array   $headers
     * @param $body
     */
    public function shouldResponsePlain(int $status = 200, $headers = [], $body = ''): self
    {
        $headers = array_merge(array_merge($headers, $this->shouldHeaderResponse()), ['Content-type' => 'text/plain']);

        $this->expectedPlainResponse = new Response($status, $headers, $body);
        return $this;
    }

    /**
     * @param int    $status
     * @param array  $headers
     * @param string $body
     */
    public function shouldResponseJson(int $status = 200, $headers = [],  ? string $body = '') : self
    {
        $body = \is_array($body) ? json_encode($body) : $body;
        $headers = array_merge(
            array_merge($headers, $this->shouldHeaderResponse()),
            ['Content-type' => 'application/json']
        );

        $this->expectedJsonResponse = new Response($status, $headers, $body);
        return $this;

    }

    /**
     * @return mixed
     */
    public function expectedResponse( ? bool $json = true) : Response
    {
        return $json ? $this->expectedJsonResponse() : $this->expectedPlainResponse();
    }

    public function expectedJsonResponse()
    {
        return \is_null($this->expectedJsonResponse) ? new Response(200, ['Content-type' => 'application/json'], '') : $this->expectedJsonResponse;
    }

    public function expectedPlainResponse()
    {
        return \is_null($this->expectedPlainResponse) ? new Response(200, ['Content-type' => 'text/plain'], '') : $this->expectedPlainResponse;
    }

    /**
     * @return mixed
     */
    public function shouldHeaderResponse(): array
    {
        return $this->expectedResponseHeaders;
    }

    public function faker(): ClientInterface
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            $this->expectedResponse(),
        ]));

        return new Client(['handler' => $handlerStack]);
    }
}
