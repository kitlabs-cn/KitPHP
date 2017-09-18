<?php
namespace KitAdminBundle\RuleManager;

interface Rule 
{
    /**
     * 
     * @param mixed $value
     * 
     * @return bool
     */
    public function apply($value);
}