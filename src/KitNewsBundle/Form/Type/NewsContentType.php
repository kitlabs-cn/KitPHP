<?php
namespace KitNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use KitBaseBundle\Form\Type\FulltextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', FulltextType::class, [
                'attr' => [
                    'id' => 'myEditor',
                    'width' => '80%',
                    'height' => '240px'
                ],
                'label' => '文章内容'
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'KitNewsBundle\Entity\NewsContent'
        ]);
    }
}