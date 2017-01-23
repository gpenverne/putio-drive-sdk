<?php
namespace Gpenverne\PutioDriveBundle\Service;

class PutioDriveService
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
