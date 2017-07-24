<?php

namespace KitRbacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleAccess
 *
 * @ORM\Table(name="role_access")
 * @ORM\Entity(repositoryClass="KitRbacBundle\Repository\RoleAccessRepository")
 */
class RoleAccess
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
     * @ORM\Column(name="role_id", type="integer", options={"comment": "角色ID"})
     */
    private $roleId;

    /**
     * @var int
     *
     * @ORM\Column(name="access_id", type="integer", options={"comment": "权限ID"})
     */
    private $accessId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", options={"comment": "创建时间"})
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", options={"comment": "更新时间"})
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="text", options={"comment": "用户名"})
     */
    private $list;


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
     * Set roleId
     *
     * @param integer $roleId
     *
     * @return RoleAccess
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set accessId
     *
     * @param integer $accessId
     *
     * @return RoleAccess
     */
    public function setAccessId($accessId)
    {
        $this->accessId = $accessId;

        return $this;
    }

    /**
     * Get accessId
     *
     * @return int
     */
    public function getAccessId()
    {
        return $this->accessId;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return RoleAccess
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return RoleAccess
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set list
     *
     * @param string $list
     *
     * @return RoleAccess
     */
    public function setList($list)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return string
     */
    public function getList()
    {
        return $this->list;
    }
}

