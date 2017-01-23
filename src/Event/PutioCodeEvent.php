<?php

namespace Gpenverne\PutioDriveBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class PutioCodeEvent extends GenericEvent
{
    const EVENT_NAME = 'events.putio.code';

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $token
     */
    public function __construct($code)
    {
        parent::__construct($code);
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
