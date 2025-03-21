<?php

namespace Guardian360\Resonance\Traits;

use Guardian360\Resonance\Contracts\DriverInterface;

trait DriverDelegator
{
    /**
     * The driver object to delegate to.
     *
     * @return \Guardian360\Resonance\Contracts\DriverInterface
     */
    abstract protected function getDriver(): DriverInterface;

    /**
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getDriver()->$key;
    }

    /**
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->getDriver()->$key = $value;
    }

    /**
     * @param  string  $method
     * @param  mixed   $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->getDriver()->$method(...$arguments);
    }
}
