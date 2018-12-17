<?php

namespace FloverartBundle\Repository;

/**
 * CategoriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriesRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCategoriesQuery( array $filter = [])
    {
        $q = $this->createQueryBuilder("p")
            ->andWhere('p.isDeleted = 0')
            ->orderBy('p.id','DESC');

        if (!empty($filter['name'])){
            $q->andWhere('p.name = :name')
                ->setParameter('name', htmlspecialchars($filter['name']));
        }

        return $q;
    }

    public function getListCategories(array $query)
    {
        $q = $this->createQueryBuilder("p")
            ->andWhere('p.isDeleted = 0');

        if (!empty($query['user_id'])) {
            $q->andWhere('p.userId = :userId')
                ->setParameter('userId', (int)$query['user_id']);
        }

        $result = [];
        $categories = $q->getQuery()->getResult();
        foreach ($categories as $item) {
            $result[$item->getId()] = $item;
        }

        return $result;
    }

    public function joinParentCategory($items, $categoriesList)
    {
        if (count($items) == 0) {
            return [];
        }

        if (count($categoriesList) == 0) {
            return $items;
        }

        foreach ($items as $k => $item) {
            if (isset($categoriesList[$item->getParentId()])) {
                $items[$k]->setParentObject($categoriesList[$item->getParentId()]);
            }
        }

        return $items;
    }

    public function calcFullName($items, $categoriesList)
    {
        foreach ($items as $k => $item) {
            $name = $this->getFullnameRecursion($item->getParentId(), $categoriesList, $item->getName(), 0);
            $items[$k]->setFullCategory($name);
        }

        return $items;
    }

    private function getFullnameRecursion($parentId, $categoriesList, $str, $index)
    {
        if ($index > 10 || $parentId === 0) {
            return $str;
        }

        if (!isset($categoriesList[$parentId])) {
            return $str;
        }

        if ($str) {
            $str = $categoriesList[$parentId]->getName() . ' → ' . $str;
        } else {
            $str = $categoriesList[$parentId]->getName();
        }



        return $this->getFullnameRecursion($categoriesList[$parentId]->getParentId(), $categoriesList, $str, $index++);
    }
}
