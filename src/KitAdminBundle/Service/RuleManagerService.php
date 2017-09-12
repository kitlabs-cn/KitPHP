<?php
namespace KitAdminBundle\Service;

use KitAdminBundle\RuleManager\Rule;

class RuleManagerService
{
    private $rules = [];
    /**
     * 
     * @param Rule $rule
     */
    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }
    
    public function applyRules(array $data)
    {
        foreach ($this->rules as $rule){
            $data = array_filter($data, function($value) use ($rule){
                return $rule->apply($value);
            });
        }
        return $data;
    }
}