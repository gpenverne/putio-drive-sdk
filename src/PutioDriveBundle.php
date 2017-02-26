<?php

namespace Gpenverne\PutioDriveBundle;

use Gpenverne\PutioDriveBundle\DependencyInjection\PutioDriveExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PutioDriveBundle extends Bundle
{
    /**
     * @return PutioDriveExtension
     */
    public function getContainerExtension()
    {
        return new PutioDriveExtension();
    }
}
