<?php
namespace KitWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="该邮箱已注册")
 */
class WebUser implements UserInterface, \Serializable
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", nullable=true,  length=255, options={"comment": "头像"})
     * @Assert\File(
     *              maxSize = "10M",
     *              mimeTypes={ "image/png", "image/jpeg", "image/jpg", "image/gif" },
     *              mimeTypesMessage = "图片格式不支持"
     * )
     */
    protected $avatar;

    

    /**
     * @ORM\Column(type="string", nullable=true, length=64)
     */
    protected $company;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=50,  options={"comment": "公司法人"})
     */
    protected $legal;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=50,  options={"comment": "公司电话"})
     */
    protected $telephone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="license", type="string", nullable=true, length=255, options={"comment": "营业执照"})
     * @Assert\File(
     *              maxSize = "10M",
     *              mimeTypes={ "image/png", "image/jpeg", "image/jpg", "image/gif" },
     *              mimeTypesMessage = "图片格式不支持"
     * )
     */
    protected $license;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $role;
    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;
    
    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", options={"comment": "状态:0未申请,1待审核,2审核通过,3拒绝"})
     */
    protected $status;
    
    /**
     * @var int
     *
     * @ORM\Column(name="user_type", type="smallint", options={"comment": "状态:0普通用户,1企业用户,2其他部门用户", "default" : 0})
     */
    protected $userType;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $note;

    public function eraseCredentials()
    {
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
    
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    public function setCompany($company)
    {
        $this->company = $company;
    }
    
    public function getCompany()
    {
        return $this->company;
    }
    
    public function setLegal($legal)
    {
        $this->legal = $legal;
    }
    
    public function getLegal()
    {
        return $this->legal;
    }
    
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    public function setLicense($license)
    {
        $this->license = $license;
    }
    
    public function getLicense()
    {
        return $this->license;
    }
    public function getUsername()
    {
        return $this->email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }
    
    /**
     * Set status
     *
     * @param integer $status
     *
     * @return News
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
    
    /**
     * Set userType
     *
     * @param integer $userType
     *
     * @return News
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    
        return $this;
    }
    
    /**
     * Get userType
     *
     * @return int
     */
    public function getUserType()
    {
        return $this->userType;
    }
    
    public function setNote($note)
    {
        $this->note = $note;
    }
    
    public function getNote()
    {
        return $this->note;
    }
    
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
            $this->password,
            $this->company,
            $this->status,
            $this->userType,
            $this->telephone,
            $this->email,
        ));
    }
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->password,
            $this->company,
            $this->status,
            $this->userType,
            $this->telephone,
            $this->email,
        ) = unserialize($serialized);
    }
}