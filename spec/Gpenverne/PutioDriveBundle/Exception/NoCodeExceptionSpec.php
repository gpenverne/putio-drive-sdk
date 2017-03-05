<?php

namespace spec\Gpenverne\PutioDriveBundle\Exception;

use Gpenverne\PutioDriveBundle\Exception\NoCodeException;
use Gpenverne\PutioDriveBundle\Exception\PutioException;
use PhpSpec\ObjectBehavior;

class NoCodeExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NoCodeException::class);
    }

    public function it_is_a_putio_exception()
    {
        $this->shouldHaveType(PutioException::class);
    }

    public function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
