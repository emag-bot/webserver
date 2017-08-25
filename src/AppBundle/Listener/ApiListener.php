<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 14:10
 */

namespace AppBundle\Listener;

use AppBundle\Controller\ApiController;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class ApiListener
{
    /** @var  Logger */
    private $logger;

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiController) {
            $data = json_decode($event->getRequest()->getContent(), true);

            if (empty($data)) {
                $data = [];
            }

            $this->logger->addDebug("[{$event->getRequest()->getMethod()}] - {$event->getRequest()->getRequestUri()}", $data);
        }
    }
}