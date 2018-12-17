<?php

namespace FloverartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="basket")
 * @ORM\Entity(repositoryClass="FloverartBundle\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer")
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;

    /**
     * @var string
     *
     * @ORM\Column(name="count", type="string", length=255)
     */
    private $count;

    /**
     * @var int
     *
     * @ORM\Column(name="admin_id", type="integer")
     */
    private $adminId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Basket
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     *
     * @return Basket
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set count
     *
     * @param string $count
     *
     * @return Basket
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set adminId
     *
     * @param integer $adminId
     *
     * @return Basket
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;

        return $this;
    }

    /**
     * Get adminId
     *
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Basket
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Basket
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
}

