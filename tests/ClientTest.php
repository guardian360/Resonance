<?php

namespace Guardian360\Resonance\Tests;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Guardian360\Resonance\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as GuzzleClient;
use Guardian360\Resonance\Contracts\DriverInterface;
use Guardian360\Resonance\Drivers\Guzzle as GuzzleDriver;

class ClientTest extends TestCase
{
    /**
     * @test
     * @return void
     * @dataProvider dataProvider
     */
    public function itShouldSelectTheAppropriateDriver($library, $instance)
    {
        $driver = new GuzzleDriver($library);
        $client = new Client($driver);

        $this->assertInstanceOf(
            $instance,
            $client->getDriver()
        );
    }

    /**
     * @test
     * @return void
     */
    public function itShouldDelegateToSelectedDriver()
    {
        $driver = new GuzzleDriver($this->getGuzzleClient());
        $client = new Client(new GuzzleDriver($this->getGuzzleClient()));

        $this->assertEquals(
            $driver->get('/'),
            $client->get('/')
        );
    }

    /**
     * @test
     * @return void
     * @expectedException \TypeError
     */
    public function itShouldThrowAnErrorWhenNoDriverCouldBeSelected()
    {
        new Client(new \StdClass);
    }

    /**
     * Provides tests with library and driver data.
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            [$this->getGuzzleClient(), GuzzleDriver::class],
        ];
    }

    /**
     * Get a Guzzle client with a mocked handler.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getGuzzleClient()
    {
        $mock = new MockHandler([
            new Response(200, [], 'some mocked content'),
            new Response(200, [], '{"some":"mocked","json":"content"}')
        ]);

        $handler = HandlerStack::create($mock);

        return new GuzzleClient(['handler' => $handler]);
    }
}
