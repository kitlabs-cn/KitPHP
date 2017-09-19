<?php

namespace KitAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BasicSetting
 *
 * @ORM\Table(name="basic_setting", options={"comment": "基础设置表"})
 * @ORM\Entity(repositoryClass="KitAdminBundle\Repository\BasicSettingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BasicSetting
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
     * @Assert\NotBlank(message="请填写网站名称")
     * @ORM\Column(name="sitename", type="string", length=32, options={"comment": "网站名称"})
     */
    private $sitename;

    /**
     * @var string
     * @Assert\Image(mimeTypesMessage="请上传正确的LOGO")
     * @ORM\Column(name="logo", type="string", length=255, options={"comment": "网站logo"})
     */
    private $logo;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写网站关键字")
     * @ORM\Column(name="keywords", type="string", length=255, options={"comment": "关键字，用于做SEO"})
     */
    private $keywords;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写网站描述")
     * @ORM\Column(name="description", type="string", length=255, options={"comment": "站点描述，用于SEO"})
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写版权信息")
     * @ORM\Column(name="copyright", type="string", length=255, options={"comment": "版权信息"})
     */
    private $copyright;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写联系方式")
     * @ORM\Column(name="contact", type="string", length=64, options={"comment": "联系方式"})
     */
    private $contact;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写ICP备案号")
     * @ORM\Column(name="icp", type="string", length=64, options={"comment": "ICP备案号"})
     */
    private $icp;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写统计代码")
     * @ORM\Column(name="code", type="string", length=255, options={"comment": "统计代码"})
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message="请填写其他内容")
     * @ORM\Column(name="other", type="text", length=65535, options={"comment": "其他"})
     */
    private $other;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updateAt;


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
     * Set sitename
     *
     * @param string $sitename
     *
     * @return BasicSetting
     */
    public function setSitename($sitename)
    {
        $this->sitename = $sitename;
    
        return $this;
    }

    /**
     * Get sitename
     *
     * @return string
     */
    public function getSitename()
    {
        return $this->sitename;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return BasicSetting
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return BasicSetting
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return BasicSetting
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set copyright
     *
     * @param string $copyright
     *
     * @return BasicSetting
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    
        return $this;
    }

    /**
     * Get copyright
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return BasicSetting
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set icp
     *
     * @param string $icp
     *
     * @return BasicSetting
     */
    public function setIcp($icp)
    {
        $this->icp = $icp;
    
        return $this;
    }

    /**
     * Get icp
     *
     * @return string
     */
    public function getIcp()
    {
        return $this->icp;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return BasicSetting
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set other
     *
     * @param string $other
     *
     * @return BasicSetting
     */
    public function setOther($other)
    {
        $this->other = $other;
    
        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return BasicSetting
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
     * @return BasicSetting
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if($this->getCreateAt() == null){
            $this->setCreateAt(new \DateTime());
        }
        if($this->getUpdateAt() == null){
            $this->setUpdateAt(new \DateTime());
        }
    
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->setUpdateAt(new \DateTime());
    }
    
}
