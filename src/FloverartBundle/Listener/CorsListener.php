<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.10.17
 * Time: 16:47
 */
namespace FloverartBundle\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;

class CorsListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $method  = $request->getRealMethod();

        if ('OPTIONS' == $method) {
            $event->setResponse(new Response());
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $responseHeaders = $event->getResponse()->headers;

        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $responseHeaders->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, x-auth-token, token');
    }
}