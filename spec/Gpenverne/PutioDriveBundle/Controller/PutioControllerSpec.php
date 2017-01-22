<?php

namespace spec\Gpenverne\PutioDriveBundle\Controller;

use Gpenverne\PutioDriveBundle\Controller\PutioController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Gpenverne\PutioDriveBundle\Event\PutioEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;

class PutioControllerSpec extends ObjectBehavior
{
    public function let(
        EventDispatcherInterface $dispatcher,
        RequestStack $requestStack,
        HttpClient $httpClient,
        UrlGenerator $urlGenerator,

        Request $request,
        \stdClass $tokenResponse
    ) {
        $urlGenerator->getRedirectUrl()->willReturn('some-url');
        $urlGenerator->getTokenUrl('the-code')->willReturn('a-token-url');

        $tokenResponse->token = 'a-token';
        $httpClient->getJson('a-token-url')->willReturn($tokenResponse);

        $requestStack->getCurrentRequest()->willReturn($request);
        $this->beConstructedWith($dispatcher, $httpClient, $requestStack, $urlGenerator);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioController::class);
    }

    public function it_redirects_to_the_putio_redirect_url($dispatcher)
    {
        $dispatcher->dispatch(Argument::Cetera())->shouldNotBeCalled();
        $this->redirectAction()->shouldHaveType(RedirectResponse::class);
    }

    public function it_dispatches_an_event_when_finding_a_token($dispatcher, $httpClient, $request, $urlGenerator)
    {
        $request->get('code')->willReturn('the-code');
        $urlGenerator->getTokenUrl('the-code')->shouldBeCalled();
        $httpClient->getJson('a-token-url')->shouldBeCalled();

        $dispatcher->dispatch(PutioEvent::TOKEN_EVENT_NAME, Argument::Type(PutioEvent::class))->shouldBeCalled();
        $this->callbackAction();
    }

    public function it_throws_a_no_code_exception_when_trying_to_get_token_without_code($request, $dispatcher)
    {
        $request->get('code')->willReturn(null);
        $dispatcher->dispatch(Argument::Cetera())->shouldNotBeCalled();
        $this->shouldThrow(NoCodeException::class)->duringCallbackAction();
    }

    public function it_throws_a_no_token_found_exception_if_putio_not_respond_with_a_token($request, $tokenResponse, $httpClient, $dispatcher)
    {
        $request->get('code')->willReturn('the-code');
        $tokenResponse = new \stdClass();
        $httpClient->getJson('a-token-url')->willReturn($tokenResponse);
        $dispatcher->dispatch(Argument::Cetera())->shouldNotBeCalled();
        $this->shouldThrow(NoTokenFoundException::class)->duringCallbackAction();
    }
}
