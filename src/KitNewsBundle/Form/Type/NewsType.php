<?php
namespace KitNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use KitAdminBundle\Form\Type\FulltextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use KitNewsBundle\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => 'KitNewsBundle:Category',
                'choice_label' => 'name',
                'query_builder' => function (CategoryRepository $repo){
                    return $repo->getCategory();
                 },
                'label' => '所属分类'
            ])
            ->add('title', null, [
                'label' => '标题'
            ])
            ->add('level', ChoiceType::class, [
                'choices' => [
                    '普通文章' => 0,
                    '头条新闻' => 1,
                    '焦点新闻' => 2,
                    '图文推荐' => 3,
                    '普通推荐' => 4,
                    '图片新闻' => 5
                ],
                'label' => '文章级别',
                'data' => 0,
                'label_attr' => [
                    'class' => 'radio-inline'
                ]
            ])
            ->add('thumb', FileType::class, [
                'label' => '标题图片',
                'data_class' => null
            ])
            ->add('keyword', null, [
                'label' => '关键字'
            ])
            ->add('author', null, [
                'label' => '作者'
            ])
            ->add('introduction', TextareaType::class, [
                'label' => '简介'
            ])
//             ->add('content', TextareaType::class, [
//                 'attr' => [
//                     'rows' => 10
//                 ],
//                 'label' => '文章内容'
//             ])
            ->add('content', FulltextType::class, [
                'attr' => [
                    'id' => 'myEditor',
                    'width' => '80%',
                    'height' => '240px'
                ],
                'label' => '文章内容'
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    '启用' => 1,
                    '禁用' => 0
                ],
                'expanded' => true,
                'label' => '状态',
                'data' => 1,
                'label_attr' => [
                    'class' =>'radio-inline'
                ]
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => '提交'
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'KitNewsBundle\Entity\News'
        ]);
    }
}