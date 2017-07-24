<?php
namespace KitNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use KitNewsBundle\Repository\CategoryRepository;
use KitNewsBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('parent', EntityType::class, [
                'class' => 'KitNewsBundle:Category',
                'query_builder' => function(CategoryRepository $repo){
                    return $repo->getParentCategory();
                },
                'choice_label' => 'name',
                'label' => '父级分类'
            ])
            ->add('name', null, [
                'label' => '分类名称'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                '启用' => 1,
                '禁用' => 0
                ],
                'expanded' => true,
                'label' => '状态',
                'data' => 1,
                'label_attr' => [
                    'class' => 'radio-inline'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => '提交'
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'KitNewsBundle\Entity\Category'
        ]);
    }
}