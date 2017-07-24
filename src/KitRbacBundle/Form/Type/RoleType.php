<?php
namespace KitRbacBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rolename', null, [
            'label' => '角色名称'
        ])
            ->add('note', null, [
            'label' => '备注'
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
            'data_class' => 'KitRbacBundle\Entity\Role'
        ]);
    }
}