<?php
namespace Gpenverne\PutioDriveBundle\Controller;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Gpenverne\PutioDriveBundle\Event\PutioEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;

class PutioController
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
     * @var Request
     */
    protected $request;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param HttpClient               $httpClient
     * @param RequestStack             $requestStack
     * @param UrlGenerator             $urlGenerator
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        HttpClient $httpClient,
        RequestStack $requestStack,
        UrlGenerator $urlGenerator
    ) {
        $this->dispatcher = $dispatcher;
        $this->httpClient = $httpClient;
        $this->request = $requestStack->getCurrentRequest();
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @throws NoCodeException
     */
    public function callbackAction()
    {
        if (null === $code = $this->request->get('code')) {
            throw new NoCodeException();
        }

        $token = $this->getToken($code);

        $event = new PutioEvent($token);
        $this->dispatcher->dispatch(PutioEvent::TOKEN_EVENT_NAME, $event);
    }

    /**
     * @return RedirectResponse
     */
    public function redirectAction()
    {
        $url = $this->urlGenerator->getRedirectUrl();

        return new RedirectResponse($url);
    }

    /**
     * @param  string $code
     * @throws NoTokenFoundException
     * @return string
     */
    protected function getToken(string $code)
    {
        $url = $this->urlGenerator->getTokenUrl($code);
        $data = $this->httpClient->getJson($url);

        if (null === $data || !is_object($data) || !isset($data->token)) {
            throw new NoTokenFoundException();
        }

        return $data->token;
    }
}
