<?php

namespace Guardian360\Resonance\Tests\Drivers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as GuzzleClient;
use Guardian360\Resonance\Drivers\Guzzle as GuzzleDriver;

class GuzzleTest extends TestCase
{
    /**
     * @test
     * @dataProvider getResponseDataProvider
     */
    public function itShouldReturnAFormattedResponse(Response $data, string $type): void
    {
        $mock = new MockHandler([$data]);
        $handler = HandlerStack::create($mock);
        $library = new GuzzleClient(['handler' => $handler]);
        $driver = new GuzzleDriver($library);

        $response = $driver->get('/');

        $assertMethod = 'assertIs'.ucfirst($type);
        $this->$assertMethod($response);
    }

    /**
     * Get response data provider
     *
     * @return array
     */
    public static function getResponseDataProvider(): array
    {
        return [
            [new Response(200, [], 'some mocked content'), 'string'],
            [new Response(200, [], '{"some":"mocked","json":"content"}'), 'array'],
        ];
    }
}
