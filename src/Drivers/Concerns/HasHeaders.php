<?php

namespace Guardian360\Resonance\Drivers\Concerns;

trait HasHeaders
{
    /**
     * The headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Get a header by its key.
     *
     * @param  int|string  $key
     * @return mixed
     */
    public function getHeader($key)
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * Get all headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set a new header.
     *
     * @param  int|string  $key
     * @param  mixed  $value
     * @return void
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Remove a header by its key.
     *
     * @return void
     */
    public function removeHeader($key)
    {
        if (isset($this->headers[$key])) {
            unset($this->headers[$key]);
        }
    }
}
