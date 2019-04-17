<?php

namespace Guardian360\Resonance\Contracts;

interface DriverInterface
{
    /**
     * Get the response body from a GET request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function get(string $query, array $data = []);

    /**
     * Get the response body from a POST request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function post(string $query, array $data = []);

    /**
     * Get the response body from a PUT request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function put(string $query, array $data = []);

    /**
     * Get the response body from a DELETE request.
     *
     * @param  string  $query
     * @return mixed
     */
    public function delete(string $query);
}
