<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Service\PutioDriveService;

class PutioTokenEventListener
{
    /**
     * @var PutioDriveService
     */
    protected $putioDriveService;

    /**
     * @param PutioDriveService $putioDriveService
     */
    public function __construct(PutioDriveService $putioDriveService)
    {
        $this->putioDriveService = $putioDriveService;
    }

    /**
     * @param  PutioEvent $event
     * @return
     */
    public function onTokenObtained(PutioTokenEvent $event)
    {
        $token = $event->getToken();

        $this->putioDriveService->setToken($token);

        return $event;
    }
}
