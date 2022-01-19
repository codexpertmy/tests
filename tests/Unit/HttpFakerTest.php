<?php

namespace Codexpert\Tests;

use Codexpert\Faker\HttpFaker;
use Mockery as m;

class HttpFakerTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function test_it_should_return_http_faker()
    {
        $client = HttpFaker::create()->shouldResponseJson(200, [], '');
        $this->assertInstanceOf('Codexpert\Faker\HttpFaker', $client);
    }

    public function test_it_should_return_guzzle_client_interface()
    {
        $client = HttpFaker::create()->shouldResponseJson(200, [], '');
        $this->assertInstanceOf('Psr\Http\Client\ClientInterface', $client->faker());
    }

    public function test_should_return_json_response()
    {
        $client = HttpFaker::create()->shouldResponseJson(200, [], '{"status":"test"}');
        $response = $client->faker()->get('/test');

        $this->assertIsArray(json_decode($response->getBody(), true));
        $this->assertInstanceOf('Psr\Http\Client\ClientInterface', $client->faker());
    }

}
