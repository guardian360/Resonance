<?php

namespace Guardian360\Resonance\Drivers;

use GuzzleHttp\Client as GuzzleClient;
use Guardian360\Resonance\Contracts\DriverInterface;

class Guzzle implements DriverInterface
{
    use Concerns\HasHeaders;

    /**
     * The Guzzle Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create the driver and set the Guzzle client.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return void
     */
    public function __construct(GuzzleClient $client)
    {
        $this->setClient($client);
    }

    /**
     * Set the Guzzle client to use.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return void
     */
    public function setClient(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get the Guzzle client.
     *
     * @return  \GuzzleHttp\Client  $client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get the response body from a GET request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function get(string $query, array $data = [])
    {
        return $this->getResponse('GET', $query, $data);
    }

    /**
     * Get the response body from a POST request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function post(string $query, array $data = [])
    {
        return $this->getResponse('POST', $query, $data);
    }

    /**
     * Get the response body from a PUT request.
     *
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    public function put(string $query, array $data = [])
    {
        return $this->getResponse('PUT', $query, $data);
    }

    /**
     * Get the response body from a DELETE request.
     *
     * @param  string  $query
     * @return mixed
     */
    public function delete(string $query)
    {
        return $this->getResponse('DELETE', $query);
    }

    /**
     * Perform a request and get the response.
     *
     * @param  string  $method
     * @param  string  $query
     * @param  array   $data
     * @return mixed
     */
    protected function getResponse(
        string $method,
        string $query,
        array $data = []
    ) {
        if (in_array(strtolower($method), ['get', 'delete']) && !empty($data)) {
            $query .= '?'.http_build_query($data);
            $data = [];
        }

        $response = $this->client->request($method, $query, [
            'headers' => $this->getHeaders(),
            'form_params' => $data,
        ]);

        return $this->formatBody($response->getBody());
    }

    /**
     * Format the response body to an array or string.
     *
     * @param  mixed  $body
     * @return array|string
     */
    protected function formatBody($body)
    {
        if ($decodedBody = json_decode((string)$body, true)) {
            return $decodedBody;
        }

        return (string)$body;
    }
}
