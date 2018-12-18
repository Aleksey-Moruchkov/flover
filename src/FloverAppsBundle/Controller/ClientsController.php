<?php

namespace FloverAppsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientsController extends Controller
{
    public function createAction()
    {
        $em = $this->getDoctrine();
        $orders = $em->getRepository('FloverartBundle:Orders')
            ->getOrdersQuery();

        return $this->json(['create']);
    }

//    public function listAction(Request $request)
//    {
//        $user = $this->getUser();
//
//        $filter = $request->query->all();
//        $filter['client_id'] = $user->getId();
//
//        $em = $this->getDoctrine();
//        $orders = $em->getRepository('FloverartBundle:Orders')
//            ->getOrdersQuery($filter);
//
//        $paginator  = $this->get('knp_paginator');
//
//        $pagination = $paginator->paginate(
//            $orders,
//            $request->query->get('page', 1),
//            $request->query->get('count', 25)
//        );
//
//        $items = $pagination->getItems();
//
//        $serializer = $this->get('floverart_api.serializer');
//
//        return $this->json([
//            [
//                'items' => $serializer->normalize($items, null, ['apps' => 1]),
//                'count' => $pagination->getTotalItemCount()
//            ]
//        ]);
//    }

}
