<?php

namespace Gpenverne\PutioDriveBundle\Service;

use GuzzleHttp\Client;

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
        return file_get_contents($url);
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function getJson($url)
    {
        return json_decode($this->get($url));
    }
}
