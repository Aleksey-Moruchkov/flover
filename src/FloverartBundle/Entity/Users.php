<?php

namespace FloverartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="FloverartBundle\Repository\UsersRepository")
 */
class Users implements UserInterface
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
     * @ORM\Column(name="login", type="string", length=50)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="string", length=255)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_at", type="string", length=255)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted_at", type="string", length=255)
     */
    private $deletedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="webhook", type="string", length=500)
     */
    private $webhook;

    /**
     * @var bool
     *
     * @ORM\Column(name="webhook_channel", type="string", length=100)
     */
    private $webhookChannel;


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
     * Set login
     *
     * @param string $login
     *
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials(){

    }

    public function getRoles(){
        return array('ROLE_USER');
    }

    public function getUsername() {
        return $this->getLogin();
    }

    public function checkRule($rule)
    {
        return true;
        //TODO
//        return in_array($rule, $this->rule);
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     *
     * @return Domains
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
     * Set updatedAt
     *
     * @param string $updatedAt
     *
     * @return Domains
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param string $deletedAt
     *
     * @return Domains
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

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Domains
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

    public function generateToken()
    {
        $string = md5(random_int(0, PHP_INT_MAX) . time(). $this->getId());

        $data = [
            'str'   => $string,
            'hash'  => md5($string . $this->getPassword()),
            'id'    => $this->getId(),
        ];

        return implode('.', $data);
    }

    /**
     * @param $password
     * @return bool
     */
    public function isCorrectPassword($password)
    {
        if (empty($this->getPassword()))
            return false;

        return ($this->getPassword() === $this->createHashPassword($password));
    }

    /**
     * @param $password
     * @return string
     */
    public function createHashPassword($password)
    {
        return sha1(trim($password));
    }

    /**
     * Set webhook
     *
     * @param string $webhook
     *
     * @return Users
     */
    public function setWebhook($webhook)
    {
        $this->webhook = $webhook;

        return $this;
    }

    /**
     * Get webhook
     *
     * @return string
     */
    public function getWebhook()
    {
        return $this->webhook;
    }

    /**
     * Set webhookChannel
     *
     * @param string $webhookChannel
     *
     * @return Users
     */
    public function setWebhookChannel($webhookChannel)
    {
        $this->webhookChannel = $webhookChannel;

        return $this;
    }

    /**
     * Get webhookChannel
     *
     * @return string
     */
    public function getWebhookChannel()
    {
        return $this->webhookChannel;
    }
}
