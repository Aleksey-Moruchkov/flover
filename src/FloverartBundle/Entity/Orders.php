<?php

namespace FloverartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="FloverartBundle\Repository\OrdersRepository")
 */
class Orders
{
    public const STATUS_NEW = 'new';
    public const STATUS_PAID = 'paid';

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
     * @ORM\Column(name="client_id", type="integer")
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="string", length=255)
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_from", type="integer")
     */
    private $amountFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_to", type="integer")
     */
    private $amountTo;

    /**
     * @var int
     *
     * @ORM\Column(name="postcard", type="integer")
     */
    private $postcard;

    /**
     * @var string
     *
     * @ORM\Column(name="product_type", type="string", length=255 )
     */
    private $productType;

    /**
     * @var int
     *
     * @ORM\Column(name="shipping_id", type="integer")
     */
    private $shippingId;


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
     * Set clientId
     *
     * @param int $clientId
     *
     * @return Orders
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Orders
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Orders
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Orders
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set amount
     *
     * @param int $amount
     *
     * @return Orders
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amountFrom
     *
     * @param int $amount
     *
     * @return Orders
     */
    public function setAmountFrom($amount)
    {
        $this->amountFrom = $amount;

        return $this;
    }

    /**
     * Get amountFrom
     *
     * @return int
     */
    public function getAmountFrom()
    {
        return $this->amountFrom;
    }


    /**
     * Set amountTo
     *
     * @param int $amount
     *
     * @return Orders
     */
    public function setAmountTo($amount)
    {
        $this->amountTo = $amount;

        return $this;
    }

    /**
     * Get amountTo
     *
     * @return int
     */
    public function getAmountTo()
    {
        return $this->amountTo;
    }

    /**
     * Set postcard
     *
     * @param int $postcard
     *
     * @return Orders
     */
    public function setPostcard($postcard)
    {
        $this->postcard = $postcard;

        return $this;
    }

    /**
     * Get postcard
     *
     * @return int
     */
    public function getPostcard()
    {
        return $this->postcard;
    }

    /**
     * Set productType
     *
     * @param string $type
     *
     * @return Orders
     */
    public function setProductType($type)
    {
        $this->productType = $type;

        return $this;
    }

    /**
     * Get productType
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set shippingId
     *
     * @param string $shippingId
     *
     * @return Orders
     */
    public function setShippingId($shippingId)
    {
        $this->shippingId = $shippingId;

        return $this;
    }

    /**
     * Get shippingId
     *
     * @return int
     */
    public function getShippingId()
    {
        return $this->shippingId;
    }
}

