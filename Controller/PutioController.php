<?php
namespace Gpenverne\PutioDriveBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Gpenverne\PutioDriveBundle\Event\PutioEvent;

class PutioController
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function callbackAction()
    {
        $token = 'http://google.fr';

        $event = new PutioEvent($token);
        $this->dispatcher->dispatch(PutioEvent::TOKEN_EVENT_NAME, $event);
    }

    /**
     * @return RedirectResponse
     */
    public function redirectAction()
    {
        $url = 'http://google.fr';

        return new RedirectResponse($url);
    }
}
