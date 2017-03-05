<?php

namespace spec\Gpenverne\PutioDriveBundle;

use Gpenverne\PutioDriveBundle\DependencyInjection\PutioDriveExtension;
use Gpenverne\PutioDriveBundle\PutioDriveBundle;
use PhpSpec\ObjectBehavior;

class PutioDriveBundleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioDriveBundle::class);
    }

    public function it_returns_a_putio_drive_extension_instance()
    {
        $this->getContainerExtension()->shouldHaveType(PutioDriveExtension::class);
    }
}
