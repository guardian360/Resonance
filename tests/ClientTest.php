<?php

namespace Guardian360\Resonance\Tests;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Guardian360\Resonance\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as GuzzleClient;
use Guardian360\Resonance\Drivers\Guzzle as GuzzleDriver;

class ClientTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function itShouldSelectTheAppropriateDriver($library, string $instance): void
    {
        $driver = new GuzzleDriver($library);
        $client = new Client($driver);

        $this->assertInstanceOf(
            $instance,
            $client->getDriver()
        );
    }

    /** @test */
    public function itShouldDelegateToSelectedDriver(): void
    {
        $driver = new GuzzleDriver($this->getGuzzleClient());
        $client = new Client(new GuzzleDriver($this->getGuzzleClient()));

        $this->assertEquals(
            $driver->get('/'),
            $client->get('/')
        );
    }

    /** @test */
    public function itShouldThrowAnErrorWhenNoDriverCouldBeSelected(): void
    {
        $this->expectException(\TypeError::class);

        new Client(new class {});
    }

    /**
     * Provides tests with library and driver data.
     *
     * @return array
     */
    public static function dataProvider(): array
    {
        return [
            [self::getGuzzleClient(), GuzzleDriver::class],
        ];
    }

    /**
     * Get a Guzzle client with a mocked handler.
     *
     * @return \GuzzleHttp\Client
     */
    protected static function getGuzzleClient(): GuzzleClient
    {
        $mock = new MockHandler([
            new Response(200, [], 'some mocked content'),
            new Response(200, [], '{"some":"mocked","json":"content"}')
        ]);

        $handler = HandlerStack::create($mock);

        return new GuzzleClient(['handler' => $handler]);
    }
}
