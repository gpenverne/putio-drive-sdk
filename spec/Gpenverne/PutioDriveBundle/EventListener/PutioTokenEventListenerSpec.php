<?php

namespace spec\Gpenverne\PutioDriveBundle\EventListener;

use Gpenverne\PutioDriveBundle\Event\PutioTokenEvent;
use Gpenverne\PutioDriveBundle\Service\PutioDriveService;
use Gpenverne\PutioDriveBundle\EventListener\PutioTokenEventListener;
use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;
use PhpSpec\ObjectBehavior;

class PutioTokenEventListenerSpec extends ObjectBehavior
{
    public function let(
        PutioApiFactory $putioDriveService,

        PutioTokenEvent $event
    ) {
        $event->getToken()->willReturn('a-token');
        $this->beConstructedWith($putioDriveService);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioTokenEventListener::class);
    }

    public function it_sets_the_token_of_the_putio_drive_service($putioDriveService, $event)
    {
        $putioDriveService->setToken('a-token')->shouldBeCalled();
        $this->onTokenObtained($event)->shouldReturn($event);
    }
}
