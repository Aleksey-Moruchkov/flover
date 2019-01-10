<?php

namespace FloverAppsBundle\Controller;

use FloverartBundle\Entity\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    private $client;

    /**
     * @return Clients
     */
    public function getUser()
    {
        $request = Request::createFromGlobals();

        if ($this->client) {
            return $this->client;
        }

        $token = $request->headers->get('Authorization');

        if (empty($token)) {
            $token = $request->get('token', '');
        }

        $token = str_replace('Bearer ', '', $token);

        $em = $this->getDoctrine()->getManager();
        $clientRepository = $em->getRepository('FloverartBundle:Clients');

        if (!$clientRepository->validateToken($token)) {
            return null;
        }

        $client = $clientRepository->getClientByToken($token);

        if (!$client) {
            return null;
        }

        if ($client->getIsDeleted()) {
            return null;
        }

        $this->client = $client;

        return $this->client;
    }
}
