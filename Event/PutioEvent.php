<?php

namespace Gpenverne\PutioDriveBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class PutioEvent extends GenericEvent
{
    const TOKEN_EVENT_NAME = 'events.putio.token';

    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        parent::__construct($token);
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
