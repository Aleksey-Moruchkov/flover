<?php

namespace FloverAppsBundle\Controller;


use Symfony\Component\HttpFoundation\Request;

class ClientsController extends MainController
{
    public function updateAction(Request $request) {
        $user = $this->getUser();

        if (!$user) {
            return $this->json('UNAUTHORIZED', 401);
        }

        $context = json_decode($request->getContent(), true);

        if (empty($context['phone']) || !preg_match('/^79(\d{9})$/', $context['phone']))
        {
            return $this->json('Error phone format', 422);
        }

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('FloverartBundle:Clients')
            ->findOneBy(['id' => (int)$user->getId(), 'isDeleted' => '0']);

        if(!$client) {
            return $this->json('Client not found', 404);
        }

        $client->setPhone($context['phone']);

        $validator = $this->get('validator');
        $errors = $validator->validate($client);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em->persist($client);
        $em->flush();

        $serializer = $this->get('floverart_api.serializer');

        return $this->json( $serializer->normalize($client, null, ['apps' => 1]));
    }
}
