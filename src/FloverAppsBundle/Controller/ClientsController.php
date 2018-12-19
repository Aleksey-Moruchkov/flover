<?php

namespace FloverAppsBundle\Controller;

use FloverartBundle\Entity\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientsController extends Controller
{
    public function tokenAction()
    {
        $em = $this->getDoctrine()->getManager();

        $client = new Clients();
        $client->setCreatedAt(date('Y-m-d H:i:s'))
            ->setIsDeleted(0);

        $rnd = substr(sha1('z' . random_int(0, PHP_INT_MAX)),5, 20);
        $client->setToken($rnd);

        $em->persist($client);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $clientRepository = $em->getRepository('FloverartBundle:Clients');

        return $this->json($clientRepository->generateToken($client, $rnd));
    }
}
