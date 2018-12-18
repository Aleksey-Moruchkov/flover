<?php

namespace FloverAppsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    private $client;

    public function getUser()
    {
        $request = Request::createFromGlobals();

        if ($this->client) {
            return $this->client;
        }

        $token = $request->get('token', '');

        $em = $this->getDoctrine()->getManager();
        $clientRepository = $em->getRepository('FloverartBundle:Clients');

        if (!$clientRepository->validateToken($token)) {
            die('401');
        }

        $client = $clientRepository->getClientByToken($token);

        if (!$client) {
            die('404');
        }

        $this->client = $client;
        return $this->client;
    }
}
