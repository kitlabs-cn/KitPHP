<?php

namespace KitRbacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuAccess
 *
 * @ORM\Table(name="menu_access")
 * @ORM\Entity(repositoryClass="KitRbacBundle\Repository\MenuAccessRepository")
 */
class MenuAccess
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
     * @ORM\Column(name="menu_id", type="integer", options={"comment": "菜单ID"})
     */
    private $menuId;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="text", options={"comment": "权限列表"})
     */
    private $list;

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
     * @return MenuAccess
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
     * Set menuId
     *
     * @param integer $menuId
     *
     * @return MenuAccess
     */
    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;

        return $this;
    }

    /**
     * Get menuId
     *
     * @return int
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * Set list
     *
     * @param string $list
     *
     * @return MenuAccess
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

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return MenuAccess
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
     * @return MenuAccess
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
}

