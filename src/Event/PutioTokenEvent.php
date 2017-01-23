<?php

namespace Gpenverne\PutioDriveBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class PutioTokenEvent extends GenericEvent
{
    const EVENT_NAME = 'events.putio.token';

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
    public function getToken()
    {
        return $this->token;
    }
}
