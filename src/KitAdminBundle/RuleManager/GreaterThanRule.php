<?php
namespace KitAdminBundle\RuleManager;

class GreaterThanRule implements Rule
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \KitAdminBundle\RuleManager\Rule::apply()
     */
    public function apply($value)
    {
        return $value > 1000;
    }
}