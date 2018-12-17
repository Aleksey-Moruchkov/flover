<?php

namespace FloverartBundle\Controller;

use FloverartBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends MainController
{
    private $rule = 'users';

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $user = new Users();
        $context = json_decode($request->getContent(), true);

        $user
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->setLogin(htmlspecialchars($context['login']))
            ->setPassword(sha1(trim($context['password'])));

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->json($user->getId());
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction($id, Request $request)
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('FloverartBundle:Users')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0']);

        if(!$users) {
            return $this->json('User not found', 404);
        }

        $context = json_decode($request->getContent(), true);

        $password = empty($context['password']) ? $user->getPassword() : sha1(trim($context['password']));

        $users
            ->setPassword($password)
            ->setWebhook(trim($context['webhook']))
            ->setWebhookChannel(trim($context['webhook_channel']));

        $validator = $this->get('validator');
        $errors = $validator->validate($users);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em->persist($users);
        $em->flush();

        return $this->json('OK');
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showAction($id)
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('FloverartBundle:Users')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0']);

        if(!$user) {
            return $this->json('User not found', 404);
        }


        $serializer = $this->get('floverart_api.serializer');

        return $this->json( $serializer->normalize($user, null, ['full' => 1]));
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction($id)
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('FloverartBundle:Users')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0']);

        if(!$user) {
            return $this->json('User not found', 404);
        }

        $user
            ->setDeletedAt(date('Y-m-d H:i:s'))
            ->setIsDeleted(true);

        $em->persist($user);
        $em->flush();

        return $this->json('OK');
    }


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $filter = $request->get('filter', []);

        if (!is_array($filter))
        {
            $this->json('Не правильно заполнен filter', 400);
        }

        $em = $this->getDoctrine();

        $users = $em->getRepository('FloverartBundle:Users')
            ->getUsersQuery($filter);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $users,
            $request->query->get('page', 1),
            $request->query->get('count', 25)
        );

        $items = $pagination->getItems();
        $serializer = $this->get('floverart_api.serializer');

        return $this->json([
            [
                'items' => $serializer->normalize($items, null, ['full' => 1]),
                'count' => $pagination->getTotalItemCount()
            ]
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function permissionsAction()
    {
        $user = $this->getUser();

        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        return $this->json(['users', 'categories']);
    }
}
