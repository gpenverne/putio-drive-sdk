<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;

class PutioTokenEventListener
{
    /**
     * @var PutioApiFactory
     */
    protected $putioApiFactory;

    /**
     * @param PutioApiFactory $putioApiFactory
     */
    public function __construct(
        PutioApiFactory $putioApiFactory
    ) {
        $this->putioApiFactory = $putioApiFactory;
    }

    /**
     * @param PutioTokenEvent $event
     *
     * @return $event
     */
    public function onTokenObtained(PutioTokenEvent $event)
    {
        $this->putioApiFactory->setToken($event->getToken());

        return $event;
    }
}
