<?php

namespace KitWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebAppeal
 *
 * @ORM\Table(name="web_appeal")
 * @ORM\Entity(repositoryClass="KitWebBundle\Repository\WebAppealRepository")
 */
class WebAppeal
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var company
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;
    
    /**
     * @var notice
     *
     * @ORM\Column(name="notice", type="string", length=255)
     */
    private $notice;

    /**
     * @var matter
     *
     * @ORM\Column(name="matter", type="string", length=255)
     */
    private $matter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="create_at", type="string", length=255)
     */
    private $createAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return WebAppeal
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set company
     *
     * @param string $company
     *
     * @return WebAppeal
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }
    
    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }
    
    /**
     * Set notice
     *
     * @param string $notice
     *
     * @return WebAppeal
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;
    
        return $this;
    }
    
    /**
     * Get notice
     *
     * @return string
     */
    public function getNotice()
    {
        return $this->notice;
    }
    
    /**
     * Set matter
     *
     * @param string $matter
     *
     * @return WebAppeal
     */
    public function setMatter($matter)
    {
        $this->matter = $matter;
    
        return $this;
    }
    
    /**
     * Get matter
     *
     * @return string
     */
    public function getMatter()
    {
        return $this->matter;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return WebAppeal
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createAt
     *
     * @param string $createAt
     *
     * @return WebAppeal
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    
        return $this;
    }

    /**
     * Get createAt
     *
     * @return string
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
}

