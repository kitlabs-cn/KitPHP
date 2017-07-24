<?php
namespace KitAdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FulltextType extends AbstractType 
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'width' => '100%',
            'height' => '240px'
        ));
    }
    
    public function getParent()
    {
        return TextareaType::class;
    }
}