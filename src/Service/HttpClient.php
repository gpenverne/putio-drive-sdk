<?php

namespace Gpenverne\PutioDriveBundle\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class HttpClient
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function get($url)
    {
        $res = $this->getResponse($url);

        return $res->getBody()->getContents();
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function getJson($url)
    {
        $res = $this->getResponse($url);

        return json_decode($res->getBody()->getContents());
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $parameters
     * @param array  $headers
     *
     * @return StreamInterface
     */
    private function getResponse($url, $method = 'GET')
    {
        return $this->client->request($method, $url, [
            'headers' => $this->getDefaultHeaders(),
        ]);
    }

    /**
     * @return array
     */
    private function getDefaultHeaders()
    {
        return [
            'Accept' => 'application/json',
        ];
    }
}
