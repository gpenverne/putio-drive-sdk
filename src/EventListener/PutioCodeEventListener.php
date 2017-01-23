<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;
use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Service\PutioDriveService;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PutioCodeEventListener
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        UrlGenerator $urlGenerator,
        HttpClient $httpClient
    ) {
        $this->dispatcher = $dispatcher;
        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
    }

    /**
     * @param  PutioEvent $event
     * @return $event
     */
    public function onCodeObtained(PutioCodeEvent $event)
    {
        $code = $event->getCode();
        $token = $this->getToken($code);

        return $this->dispatchEvent($token);
    }

    /**
     * @param  string $code
     *
     * @throws NoTokenFoundException
     *
     * @return PutioTokenEvent
     */
    public function getToken($code)
    {
        $url = $this->urlGenerator->getTokenUrl($code);
        $data = $this->httpClient->getJson($url);

        if (null === $data || !is_object($data) || !isset($data->token)) {
            throw new NoTokenFoundException();
        }

        return $data->token;
    }

    /**
     * @param  string $token
     *
     * @return PutioCodeEvent
     */
    protected function dispatchEvent($token)
    {
        $event = new PutioTokenEvent($token);
        $this->dispatcher->dispatch(PutioTokenEvent::EVENT_NAME, $event);

        return $event;
    }
}
