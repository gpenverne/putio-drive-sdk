<?php

namespace Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;
use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
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
     * @param PutioEvent $event
     *
     * @return $event
     */
    public function onCodeObtained(PutioCodeEvent $event)
    {
        $code = $event->getCode();
        $token = $this->getToken($code);

        return $this->dispatchEvent($token);
    }

    /**
     * @param string $code
     *
     * @throws NoTokenFoundException
     *
     * @return PutioTokenEvent
     */
    public function getToken($code)
    {
        $url = $this->urlGenerator->getTokenUrl();
        $parameters = $this->urlGenerator->getTokenUrlParameters($code);

        $data = $this->httpClient->getJson($url, $parameters);

        if (null === $data || !is_object($data) || !isset($data->access_token)) {
            $result = $data;
            $debug = [
                'last_url' => $url,
                'result' => $data,
            ];
            throw new NoTokenFoundException(json_encode($debug));
        }

        return $data->access_token;
    }

    /**
     * @param string $token
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
