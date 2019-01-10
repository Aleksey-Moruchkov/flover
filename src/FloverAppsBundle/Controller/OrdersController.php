<?php

namespace FloverAppsBundle\Controller;

use FloverartBundle\Entity\Orders;
use FloverartBundle\Entity\Ship;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends MainController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json('UNAUTHORIZED', 401);
        }


        $order = new Orders();
        $context = json_decode($request->getContent(), true);

        $order
            ->setPhone(isset($context['phone']) ? $context['phone'] : '')
            ->setAmount(0)
            ->setStatus(Orders::STATUS_NEW)
            ->setPostcard((int)(!empty($context['postcard'])))
            ->setAmountTo(isset($context['amount_to']) ? $context['amount_to'] : 0)
            ->setClientId($user->getId())
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->setProductType(isset($context['product_type']) ? $context['product_type'] : 'box')
            ->setAmountFrom(isset($context['amount_from']) ? $context['amount_from'] : 0)
            ->setShippingId(isset($context['shipping_id']) ? (int)$context['shipping_id'] : 0)
            ->setComment(isset($context['comment']) ? $context['comment'] : '');

        $validator = $this->get('validator');
        $errors = $validator->validate($order);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em = $this->getDoctrine()->getManager();

        if (!$order->getShippingId() && !empty($context['shipping'])) {
            $ship = new Ship();
            $ship
                ->setClientId($user->getId())
                ->setAddress($context['shipping'])
                ->setCreatedAt(date('Y-m-d H:i:s'));

            $em->persist($ship);
            $em->flush();

            $order->setShippingId($ship->getId());
            $order->setShip($ship);
        } else {
            $ship = $em->getRepository('FloverartBundle:Ship')
                ->getShipById($order->getShippingId(), $user);

            if ($ship) {
                $order->setShip($ship);
            }
        }

        $em->persist($order);
        $em->flush();

        $serializer = $this->get('floverart_api.serializer');

        return $this->json($serializer->normalize($order, null, ['apps' => 1]));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \LogicException
     */
    public function listAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json('UNAUTHORIZED', 401);
        }

        $filter = $request->query->all();
        $filter['client_id'] = $user->getId();

        $em = $this->getDoctrine();
        $orders = $em->getRepository('FloverartBundle:Orders')
            ->getOrdersQuery($filter);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $orders,
            $request->query->get('page', 1),
            $request->query->get('count', 25)
        );

        $items = $pagination->getItems();

        $em = $this->getDoctrine()->getManager();

        $shipIds = array_map(function ($item){ return $item->getShippingId(); }, $items);
        $ships = $em->getRepository('FloverartBundle:Ship')
            ->getShipByIds($shipIds, $user);

        $items = $em->getRepository('FloverartBundle:Orders')
            ->joinShips($items, $ships);

        $serializer = $this->get('floverart_api.serializer');

        return $this->json([
            [
                'items' => $serializer->normalize($items, null, ['apps' => 1]),
                'count' => $pagination->getTotalItemCount()
            ]
        ]);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showAction($id)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json('UNAUTHORIZED', 401);
        }

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('FloverartBundle:Orders')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0', 'clientId' => $user->getId()]);

        if(!$order) {
            return $this->json('Order not found', 404);
        }


        $serializer = $this->get('floverart_api.serializer');

        return $this->json( $serializer->normalize($order, null, ['apps' => 1]));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction($id, Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json('UNAUTHORIZED', 401);
        }

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('FloverartBundle:Orders')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0', 'clientId' => $user->getId()]);

        if(!$order) {
            return $this->json('Order not found', 404);
        }

        $context = json_decode($request->getContent(), true);

        $order
            ->setPhone(isset($context['phone']) ? $context['phone'] : '')
            ->setStatus(Orders::STATUS_NEW)
            ->setPostcard((int)(!empty($context['postcard'])))
            ->setAmountTo(isset($context['amount_to']) ? $context['amount_to'] : 0)
            ->setProductType(isset($context['product_type']) ? $context['product_type'] : 'box')
            ->setAmountFrom(isset($context['amount_from']) ? $context['amount_from'] : 0)
            ->setComment(isset($context['comment']) ? $context['comment'] : '');

        $validator = $this->get('validator');
        $errors = $validator->validate($order);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em = $this->getDoctrine()->getManager();

        if (!empty($context['shipping']) ) {
            $ship = new Ship();
            $ship
                ->setClientId($user->getId())
                ->setAddress($context['shipping'])
                ->setCreatedAt(date('Y-m-d H:i:s'));

            $em->persist($ship);
            $em->flush();

            $order->setShippingId($ship->getId());
            $order->setShip($ship);
        } else {
            $ship = $em->getRepository('FloverartBundle:Ship')
                ->getShipById($order->getShippingId(), $user);

            if ($ship) {
                $order->setShip($ship);
            }
        }

        $em->persist($order);
        $em->flush();

        $serializer = $this->get('floverart_api.serializer');

        return $this->json($serializer->normalize($order, null, ['apps' => 1]));
    }

}
