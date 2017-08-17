<?php
namespace KitWebBundle\Twig;

class ThemeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('theme', array($this, 'themeFilter')),
        );
    }
    
    public function themeFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;
        
        return $price;
    }
}