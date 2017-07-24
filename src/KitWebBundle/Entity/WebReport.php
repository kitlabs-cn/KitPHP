<?php

namespace KitWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WebReport
 *
 * @ORM\Table(name="web_report")
 * @ORM\Entity(repositoryClass="KitWebBundle\Repository\WebReportRepository")
 */
class WebReport
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
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=11)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cardid", type="string", length=64)
     */
    private $cardid;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb", type="string", nullable=true,  length=255, options={"comment": "举报图片"})
     * @Assert\File(
     *              maxSize = "10M",
     *              mimeTypes={ "image/png", "image/jpeg", "image/jpg", "image/gif" },
     *              mimeTypesMessage = "图片格式不支持"
     * )
     */
    private $thumb;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="createAt", type="string", length=255)
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
     * @return WebReport
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
     * Set mobile
     *
     * @param string $mobile
     *
     * @return WebReport
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return WebReport
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
     * Set cardid
     *
     * @param string $cardid
     *
     * @return WebReport
     */
    public function setCardid($cardid)
    {
        $this->cardid = $cardid;
    
        return $this;
    }
    
    /**
     * Get cardid
     *
     * @return string
     */
    public function getCardid()
    {
        return $this->cardid;
    }
    
    /**
     * Set thumb
     *
     * @param string $thumb
     *
     * @return WebReport
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    
        return $this;
    }
    
    /**
     * Get thumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }
    
    /**
     * Set content
     *
     * @param string $content
     *
     * @return WebReport
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
     * @return WebReport
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

