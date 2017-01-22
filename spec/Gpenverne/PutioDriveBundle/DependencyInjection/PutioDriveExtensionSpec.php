<?php

namespace spec\Gpenverne\PutioDriveBundle\DependencyInjection;

use Gpenverne\PutioDriveBundle\DependencyInjection\PutioDriveExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PutioDriveExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PutioDriveExtension::class);
    }

    public function it_loads_yml_config_files(YamlFileLoader $loader, ContainerBuilder $container)
    {
        $this->load([], $container);
    }
}
