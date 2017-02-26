<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;
use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Service\PutioDriveService;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * @param  PutioTokenEvent $event
     * @return $event
     */
    public function onTokenObtained(PutioTokenEvent $event)
    {
        $this->putioApiFactory->setToken($event->getToken());

        return $event;
    }
}
