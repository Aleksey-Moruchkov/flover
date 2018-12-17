<?php

namespace FloverartBundle\Controller;

use FloverartBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends MainController
{
    private $rule = 'categories';

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

        $category = new Categories();

        $context = json_decode($request->getContent(), true);

        if (empty($context['name'])) {
            return $this->json(['errors' => ['name' => 'Empty name']], 422);
        }

        if (empty($context['parent_id'])) {
            $context['parent_id'] = 0;
        }

        if (empty($context['sort'])) {
            $context['sort'] = 0;
        }

        $category
            ->setUserId((int)$user->getId())
            ->setParentId((int)$context['parent_id'])
            ->setName(htmlspecialchars($context['name']))
            ->setSort((int)$context['sort'])
            ->setCreatedAt(date('Y-m-d H:i:s'));

        $validator = $this->get('validator');
        $errors = $validator->validate($category);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return $this->json($category->getId());
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
        $category = $em->getRepository('FloverartBundle:Categories')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0', 'userId' => $user->getId()]);

        if(!$category) {
            return $this->json('Category not found', 404);
        }

        $context = json_decode($request->getContent(), true);

        if (empty($context['name'])) {
            return $this->json(['errors' => ['name' => 'Empty name']], 422);
        }

        if (empty($context['parent_id'])) {
            $context['parent_id'] = 0;
        }

        if (empty($context['sort'])) {
            $context['sort'] = 0;
        }

        $category
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->setName(htmlspecialchars($context['name']))
            ->setParentId((int)$context['parent_id'])
            ->setSort((int)$context['sort']);

        $validator = $this->get('validator');
        $errors = $validator->validate($category);

        if ($errors->count() > 0) {
            $serializer = $this->get('floverart_api.serializer');
            return $this->json($serializer->normalize($errors), 422);
        }

        $em->persist($category);
        $em->flush();

        return $this->json('OK');
    }


    /**
     * @param         $id
     * @param Request $request
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
        $category = $em->getRepository('FloverartBundle:Categories')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0', 'userId' => $user->getId()]);

        if(!$category) {
            return $this->json('Category not found', 404);
        }

        $serializer = $this->get('floverart_api.serializer');

        return $this->json($serializer->normalize($category, null , ['full' => 1]));
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
        $category = $em->getRepository('FloverartBundle:Categories')
            ->findOneBy(['id' => (int)$id, 'isDeleted' => '0', 'userId' => $user->getId()]);

        if(!$category) {
            return $this->json('Category not found', 404);
        }

        $category
            ->setDeletedAt(date('Y-m-d H:i:s'))
            ->setIsDeleted(true);

        $em->persist($category);
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

        $category = $em->getRepository('FloverartBundle:Categories')
            ->getCategoriesQuery($filter)
            ->andWhere('p.userId = :userId')
            ->setParameter('userId', $user->getId());

        $categoriesList = $em->getRepository('FloverartBundle:Categories')
            ->getListCategories(['userId' => $user->getId(), 'isDeleted' => 0]);


        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $category,
            $request->query->get('page', 1),
            $request->query->get('count', 25)
        );

        $items = $em->getRepository('FloverartBundle:Categories')
            ->joinParentCategory($pagination->getItems(), $categoriesList);

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
    public function listFullAction()
    {
        $user = $this->getUser();
        if (!$user || !$user->checkRule($this->rule))
        {
            return $this->json('403 Access denied', 403);
        }

        $em = $this->getDoctrine();

        $category = $em->getRepository('FloverartBundle:Categories')
            ->findBy(['userId' => $user->getId(), 'isDeleted' => 0]);

        $categoryList = $em->getRepository('FloverartBundle:Categories')
            ->getListCategories([]);

        $category = $em->getRepository('FloverartBundle:Categories')
            ->calcFullName($category, $categoryList);

        usort($category, function ($a, $b) {
            return strnatcmp(strtolower($a->getFullCategory()), strtolower($b->getFullCategory()));
        });

        $serializer = $this->get('floverart_api.serializer');

        return $this->json($serializer->normalize($category));
    }
}
