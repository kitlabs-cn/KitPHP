<?php
namespace KitAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="KitAdminBundle\Repository\AdminRepository")
 */
class Admin implements AdvancedUserInterface, \Serializable
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string @ORM\Column(name="username", type="string", length=60, unique=true, options={"comment": "用户名"})
     */
    protected $username;

    /**
     *
     * @var string @ORM\Column(name="password", type="string", length=120)
     */
    protected $password;
    
    /**
     *
     * @var string @ORM\Column(name="salt", type="string", length=8)
     */
    protected $salt;
    
    /**
     *
     * @var string @ORM\Column(name="truename", type="string", length=30, nullable=true)
     */
    private $truename;

    /**
     *
     * @var string @ORM\Column(name="cardid", type="string", length=18)
     */
    private $cardid;

    /**
     *
     * @var string @ORM\Column(name="number", type="string", length=32, unique=true)
     */
    private $number;

    /**
     *
     * @var int @ORM\Column(name="gender", type="smallint")
     */
    private $gender;

    /**
     *
     * @var int @ORM\Column(name="mobile", type="bigint")
     */
    private $mobile;

    /**
     *
     * @var int @ORM\Column(name="city_id", type="integer")
     */
    private $cityId;

    /**
     *
     * @var int @ORM\Column(name="suboffice_id", type="integer")
     */
    private $subofficeId;

    /**
     *
     * @var string @ORM\Column(name="job_title", type="string", length=64)
     */
    private $jobTitle;

    /**
     *
     * @var int @ORM\Column(name="admin_role_id", type="integer")
     */
    private $adminRoleId;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\Column(name="last_login", type="datetimetz")
     */
    private $lastLogin;
    
    /**
     * Many admins have One role.
     * @ORM\ManyToOne(targetEntity="AdminRole", inversedBy="roles")
     * @ORM\JoinColumn(name="admin_role_id", referencedColumnName="id")
     */
    private $role;
    
    public function __construct() {
        $this->role = new ArrayCollection();
    }
    
    /**
     * Get role
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRoles()
    {
        return $this->role;
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
     * Set username
     *
     * @param string $username            
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password            
     *
     * @return User
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
     * Set password salt
     *
     * @param string $password
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }
    
    /**
     * Get password salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * Set truename
     *
     * @param string $truename            
     *
     * @return User
     */
    public function setTruename($truename)
    {
        $this->truename = $truename;
        
        return $this;
    }

    /**
     * Get truename
     *
     * @return string
     */
    public function getTruename()
    {
        return $this->truename;
    }

    /**
     * Set cardid
     *
     * @param string $cardid            
     *
     * @return User
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
     * Set number
     *
     * @param string $number            
     *
     * @return User
     */
    public function setNumber($number)
    {
        $this->number = $number;
        
        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set gender
     *
     * @param integer $gender            
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        
        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set mobile
     *
     * @param integer $mobile            
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        
        return $this;
    }

    /**
     * Get mobile
     *
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId            
     *
     * @return User
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
        
        return $this;
    }

    /**
     * Get cityId
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set subofficeId
     *
     * @param integer $subofficeId            
     *
     * @return User
     */
    public function setSubofficeId($subofficeId)
    {
        $this->subofficeId = $subofficeId;
        
        return $this;
    }

    /**
     * Get subofficeId
     *
     * @return int
     */
    public function getSubofficeId()
    {
        return $this->subofficeId;
    }

    /**
     * Set jobTitle
     *
     * @param string $jobTitle            
     *
     * @return User
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
        
        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set adminRoleId
     *
     * @param integer $adminRoleId            
     *
     * @return User
     */
    public function setAdminRoleId($adminRoleId)
    {
        $this->adminRoleId = $adminRoleId;
        
        return $this;
    }

    /**
     * Get adminRoleId
     *
     * @return int
     */
    public function getAdminRoleId()
    {
        return $this->adminRoleId;
    }

    /**
     *
     * @param bool $boolean            
     *
     * @return self
     */
    public function setEnabled($boolean)
    {
        $this->isActive = $boolean;
        return $this;
    }

    /**
     * Sets the last login time.
     *
     * @param \DateTime $time            
     *
     * @return self
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;
        return $this;
    }
    
    /**
     * Get the last login time
     * 
     * @return DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    
    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *        
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *        
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *        
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *        
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }
    /**
     * serialize
     * 
     * @see Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    /**
     *
     * @param
     *            serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ) = unserialize($serialized);
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {}
}

