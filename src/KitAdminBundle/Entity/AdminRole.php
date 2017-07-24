<?php

namespace KitAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * AdminRole
 *
 * @ORM\Table(name="admin_role")
 * @ORM\Entity(repositoryClass="KitAdminBundle\Repository\AdminRoleRepository")
 */
class AdminRole implements RoleInterface
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=64)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="access_ids", type="string", length=255)
     */
    private $accessIds;

    /**
     * @var string
     *
     * @ORM\Column(name="access_list", type="text")
     */
    private $accessList;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * One role has Many Admins.
     * 
     * @ORM\OneToMany(targetEntity="Admin", mappedBy="AdminRole")
     */
    private $roles;
    
    public function __construct() {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get admins
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAdmins()
    {
        return $this->admins;
    }
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
     * Set name
     *
     * @param string $name
     *
     * @return AdminRole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role name
     *
     * @param string $role
     *
     * @return AdminRole
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }
    
    /**
     * Get role name
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * Set accessIds
     *
     * @param string $accessIds
     *
     * @return AdminRole
     */
    public function setAccessIds($accessIds)
    {
        $this->accessIds = $accessIds;

        return $this;
    }

    /**
     * Get accessIds
     *
     * @return string
     */
    public function getAccessIds()
    {
        return $this->accessIds;
    }

    /**
     * Set accessList
     *
     * @param string $accessList
     *
     * @return AdminRole
     */
    public function setAccessList($accessList)
    {
        $this->accessList = $accessList;

        return $this;
    }

    /**
     * Get accessList
     *
     * @return string
     */
    public function getAccessList()
    {
        return $this->accessList;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return AdminRole
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}

