<?php

namespace spec\Gpenverne\PutioDriveBundle\Controller;

use Gpenverne\PutioDriveBundle\Controller\PutioController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;

class PutioControllerSpec extends ObjectBehavior
{
    public function let(
        UrlGenerator $urlGenerator,
        PutioApiFactory $putioDrive
    ) {
        $urlGenerator->getRedirectUrl()->willReturn('some-url');

        $this->beConstructedWith($urlGenerator, $putioDrive);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioController::class);
    }

    public function it_redirects_to_the_putio_redirect_url($dispatcher)
    {
        $this->redirectAction()->shouldHaveType(RedirectResponse::class);
    }
}
