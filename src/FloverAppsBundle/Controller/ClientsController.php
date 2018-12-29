<?php

namespace FloverAppsBundle\Controller;

use FloverartBundle\Entity\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClientsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tokenAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $client = new Clients();
        $client->setCreatedAt(date('Y-m-d H:i:s'))
            ->setIsDeleted(0);

        $rnd = substr(sha1('z' . random_int(0, PHP_INT_MAX)),5, 20);
        $client->setToken($rnd);
        $client->setUniqId($request->query->get('uniq',''));

        $em->persist($client);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $clientRepository = $em->getRepository('FloverartBundle:Clients');

        return $this->json($clientRepository->generateToken($client, $rnd));
    }
}
