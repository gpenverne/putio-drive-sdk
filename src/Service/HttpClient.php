<?php

namespace Gpenverne\PutioDriveBundle\Service;

class HttpClient
{
    /**
     * @param  string $url
     * @return string
     */
    public function get(string $url)
    {
        return file_get_contents($url);
    }

    /**
     * @param  string $url
     *
     * @return mixed
     */
    public function getJson(string $url)
    {
        return json_decode($this->get($url));
    }
}