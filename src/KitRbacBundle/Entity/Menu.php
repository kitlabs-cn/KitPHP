<?php

namespace KitRbacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="KitRbacBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="menuname", type="string", length=64, options={"comment": "菜单名称"})
     */
    private $menuname;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_url", type="string", length=255, options={"comment": "菜单的URL"})
     */
    private $menuUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="pid", type="integer", options={"comment": "父级ID"})
     */
    private $pid;

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
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", options={"comment": "状态，1正常，0禁用"})
     */
    private $status;


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
     * Set menuname
     *
     * @param string $menuname
     *
     * @return Menu
     */
    public function setMenuname($menuname)
    {
        $this->menuname = $menuname;

        return $this;
    }

    /**
     * Get menuname
     *
     * @return string
     */
    public function getMenuname()
    {
        return $this->menuname;
    }

    /**
     * Set menuUrl
     *
     * @param string $menuUrl
     *
     * @return Menu
     */
    public function setMenuUrl($menuUrl)
    {
        $this->menuUrl = $menuUrl;

        return $this;
    }

    /**
     * Get menuUrl
     *
     * @return string
     */
    public function getMenuUrl()
    {
        return $this->menuUrl;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     *
     * @return Menu
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Menu
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
     * @return Menu
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
     * Set status
     *
     * @param integer $status
     *
     * @return Menu
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

