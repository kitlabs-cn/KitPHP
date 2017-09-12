<?php
namespace KitAdminBundle\RuleManager;

class IsNumericRule implements Rule
{
    /**
     * 
     * {@inheritDoc}
     * @see \KitAdminBundle\RuleManager\Rule::apply()
     */
    public function apply($value)
    {
        return is_numeric($value);
    }
}