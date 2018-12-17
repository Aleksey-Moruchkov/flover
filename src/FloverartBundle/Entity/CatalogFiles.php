<?php

namespace FloverartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatalogFiles
 *
 * @ORM\Table(name="catalog_files")
 * @ORM\Entity(repositoryClass="FloverartBundle\Repository\CatalogFilesRepository")
 */
class CatalogFiles
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
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255)
     */
    private $img;

    /**
     * @var int
     *
     * @ORM\Column(name="catalog_id", type="integer")
     */
    private $catalogId;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="string", length=255)
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted_at", type="string", length=255)
     */
    private $deletedAt;


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
     * Set img
     *
     * @param string $img
     *
     * @return CatalogFiles
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set catalogId
     *
     * @param integer $catalogId
     *
     * @return CatalogFiles
     */
    public function setCatalogId($catalogId)
    {
        $this->catalogId = $catalogId;

        return $this;
    }

    /**
     * Get catalogId
     *
     * @return int
     */
    public function getCatalogId()
    {
        return $this->catalogId;
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     *
     * @return CatalogFiles
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return CatalogFiles
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

    /**
     * Set deletedAt
     *
     * @param string $deletedAt
     *
     * @return CatalogFiles
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}

