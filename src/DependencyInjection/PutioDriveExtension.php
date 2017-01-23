<?php
namespace Gpenverne\PutioDriveBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class PutioDriveExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load($configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('parameters.yml');
        $loader->load('services.yml');

        return $this->generateRoutes();
    }

    protected function generateRoutes()
    {
        $routesCollection = new RouteCollection();

        $route = new Route('/putio/callback', [
            '_controller' => 'putio.drive.controller:callbackAction',
        ]);
        $routesCollection->add('putio.callback', $route);

        $route = new Route('/putio/redirect', [
            '_controller' => 'putio.drive.controller:redirectAction',
        ]);
        $routesCollection->add('putio.redirect', $route);

        return $routesCollection;
    }
}
