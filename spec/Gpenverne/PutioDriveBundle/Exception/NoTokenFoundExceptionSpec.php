<?php
namespace spec\Gpenverne\PutioDriveBundle\Exception;

use Gpenverne\PutioDriveBundle\Exception\NoTokenFoundException;
use Gpenverne\PutioDriveBundle\Exception\PutioException;
use PhpSpec\ObjectBehavior;

class NoTokenFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NoTokenFoundException::class);
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
