<?php

namespace Guardian360\Resonance;

use Guardian360\Resonance\Traits\DriverDelegator;
use Guardian360\Resonance\Contracts\DriverInterface;

class Client
{
    use DriverDelegator;

    /**
     * The driver to make requests with.
     *
     * @var \Guardian360\Resonance\Contracts\DriverInterface
     */
    protected $driver;

    /**
     * Instantiate the client.
     *
     * @param  mixed  $library
     * @return void
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Get the selected driver.
     *
     * @return \Guardian360\Resonance\Contract\DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
