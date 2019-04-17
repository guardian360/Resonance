<?php

namespace Resonance\Tests\Drivers;

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
     * @return void
     * @dataProvider getResponseDataProvider
     */
    public function itShouldReturnAFormattedResponse($data, $type)
    {
        $mock = new MockHandler([$data]);
        $handler = HandlerStack::create($mock);
        $library = new GuzzleClient(['handler' => $handler]);
        $driver = new GuzzleDriver($library);

        $response = $driver->get('/');

        $this->assertInternalType($type, $response);
    }

    /**
     * Get response data provider
     *
     * @return array
     */
    public function getResponseDataProvider()
    {
        return [
            [new Response(200, [], 'some mocked content'), 'string'],
            [new Response(200, [], '{"some":"mocked","json":"content"}'), 'array'],
        ];
    }
}
