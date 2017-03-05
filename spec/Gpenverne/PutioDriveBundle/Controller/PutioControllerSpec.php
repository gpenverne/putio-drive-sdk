<?php

namespace spec\Gpenverne\PutioDriveBundle\Controller;

use Gpenverne\PutioDriveBundle\Controller\PutioController;
use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
