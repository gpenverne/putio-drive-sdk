<?php
namespace Gpenverne\PutioDriveBundle\Controller;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;

class PutioController
{
    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(
        UrlGenerator $urlGenerator
    ) {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return RedirectResponse
     */
    public function redirectAction()
    {
        $url = $this->urlGenerator->getRedirectUrl();

        return new RedirectResponse($url);
    }
}
