<?php
namespace KitWebBundle\Repository;

/**
 * WebUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WebUserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Query Builder is an api to construct queries, 
     * so it's easier if you need to build a query 
     * dynamically like iterating over a set of parameters 
     * or filters.
     * 
     */
//     public function loadUserByUsername($email)
//     {
//         return $this->createQueryBuilder('u')
//             //->select('u.id', 'u.username', 'u.createAt', 'u.updateAt', 'r.rolename')
//             //->join('u.roles', 'r')
//             //->where('u.status = ?0')
//             //->setParameter(0, 1) // key, The parameter position or name
//             ->where('u.email = :email')
//             ->setParameter('email', $email)
//             ->getQuery()
//             ->getResult();
        
       
//     }
}
