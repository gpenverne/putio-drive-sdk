<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;

class PutioEndPointSubscriber
{
    /**
     * @var EventDispatcherInterface
     */
     protected $dispatcher;

     /**
      * @var string
      */
     protected $routeName;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        string $routeName
    ) {
        $this->dispatcher = $dispatcher;
        $this->routeName = $routeName;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (false === $this->shouldProcess($request)) {
            return $event;
        }

        $this->dispatchEvent($request->get('code'));
    }

    /**
     * @param  Request $request
     *
     * @return bool
     */
    protected function shouldProcess(Request $request)
    {
        $routeName = $request->attributes->get('_route');

        return $routeName === $this->routeName && $request->get('code');
    }

    /**
     * @param  string $code
     *
     * @return PutioCodeEvent
     */
    protected function dispatchEvent(string $code)
    {
        $event = new PutioCodeEvent($code);
        $this->dispatcher->dispatch(PutioCodeEvent::EVENT_NAME, $event);

        return $event;
    }
}