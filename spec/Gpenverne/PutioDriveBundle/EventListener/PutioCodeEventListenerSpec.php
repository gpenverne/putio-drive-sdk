<?php

namespace spec\Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioCodeEvent;
use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Service\HttpClient;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PutioCodeEventListenerSpec extends ObjectBehavior
{
    public function let(
        EventDispatcherInterface $dispatcher,
        UrlGenerator $urlGenerator,
        HttpClient $httpClient,

        PutioCodeEvent $event,
        \stdClass $tokenStd
    ) {
        $tokenStd->access_token = 'a-token';

        $event->getCode()->willReturn('a-code');
        $urlGenerator->getTokenUrl('a-code')->willReturn('an-url');
        $httpClient->getJson('an-url')->willReturn($tokenStd);

        $this->beConstructedWith($dispatcher, $urlGenerator, $httpClient);
    }

    public function it_dispatches_a_token_event_on_code_obtained($dispatcher, $event)
    {
        $dispatcher->dispatch(PutioTokenEvent::EVENT_NAME, Argument::Type(PutioTokenEvent::class))->shouldBeCalled();
        $this->onCodeObtained($event)->shouldHaveType(PutioTokenEvent::class);
    }

    public function it_retrieves_a_token($event)
    {
        $this->getToken('a-code')->shouldReturn('a-token');
        $this->onCodeObtained($event)->shouldHaveType(PutioTokenEvent::class);
    }

    public function it_throws_a_no_token_exception_if_no_token_found($tokenStd, $event, $httpClient)
    {
        $httpClient->getJson('an-url')->willReturn('something wrong');
        $this->shouldThrow(NoTokenFoundException::class)->duringGetToken('a-code');
    }
}
