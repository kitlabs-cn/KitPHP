<?php

namespace KitAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTest
 *
 * @ORM\Table(name="user_test")
 * @ORM\Entity
 */
class UserTest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=32, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=11, nullable=false)
     */
    private $mobile;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;


}

