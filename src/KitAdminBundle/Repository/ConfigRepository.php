<?php

namespace KitAdminBundle\Repository;

/**
 * ConfigRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConfigRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPageQuery($cid)
    {
        return $this->createQueryBuilder('c')
        ->where('c.categoryId = :cid')
        ->setParameter('cid', $cid)
        ->orderBy('c.id', 'DESC')
        ->getQuery();
    }
    
    public function getList($name, $limit)
    {
        return $this->getEntityManager()
        ->getConnection()
        ->executeQuery('SELECT c.*, cc.title FROM config as c LEFT JOIN config_category as cc ON c.category_id = cc.id WHERE cc.name = :name AND c.status = 1 ORDER BY c.level DESC LIMIT ' . $limit, [
            'name' => $name
        ])
        ->fetchAll();
    }
    
    public function getValue($name)
    {
        return $this->getEntityManager()
        ->getConnection()
        ->executeQuery('SELECT c.*, cc.title FROM config as c LEFT JOIN config_category as cc ON c.category_id = cc.id WHERE cc.name = :name AND c.status = 1 ORDER BY c.level DESC', [
            'name' => $name
        ])
        ->fetchColumn(2);
    }
}
