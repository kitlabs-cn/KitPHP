<?php
/**
 * Author: lcp0578@gmail.com
 * 
 * Date: 2017/01/22
 * Time: 18:26
 */
namespace KitAdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdminBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

//     public function setContainer(ContainerInterface $container = null)
//     {}

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        //$em = $this->container->get('doctrine')->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $menu = $factory->createItem('root', [
            'label' => '主菜单'
        ]);
        
        $menu->addChild('kit_admin_homepage', [
            'route' => 'kit_admin_homepage',
            'label' => '首页',
            'attributes' => [
                'icon' => 'icon-home'
            ]
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_homepage', [
            'route' => 'kit_admin_homepage',
            'label' => '欢迎页'
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_flow', [
            'route' => 'kit_admin_flow',
            'label' => '执法流程图'
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_user', [
            'route' => 'kit_admin_user',
            'label' => '前台用户'
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_user_password', [
            'route' => 'kit_admin_user_password',
            'label' => '用户修改密码',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_user_show', [
            'route' => 'kit_admin_user_show',
            'label' => '用户信息',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        
        $menu['kit_admin_homepage']->addChild('kit_admin_user_check', [
            'route' => 'kit_admin_user_check',
            'label' => '用户审核',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_appeal', [
            'route' => 'kit_admin_appeal',
            'label' => '申诉陈辩'
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_appeal_show', [
            'route' => 'kit_admin_appeal_show',
            'label' => '申诉详情',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_report', [
            'route' => 'kit_admin_report',
            'label' => '群众举报'
        ]);
        $menu['kit_admin_homepage']->addChild('kit_admin_report_show', [
            'route' => 'kit_admin_report_show',
            'label' => '举报详情',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        // access services from the container!
        // $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        // $blog = $em->getRepository('KitAdminBundle:Admin')->findMostRecent();
        if(1 == $user->getRoleId()){
            $menu->addChild('kit_rbac_user', array(
                'route' => 'kit_rbac_user',
                'label' => '系统',
                'attributes' => [
                    'icon' => 'icon-cog'
                ]
            ))
            // 'routeParameters' => array('id' => $blog->getId())
            ;
            $menu['kit_rbac_user']->addChild('kit_rbac_user', [
                'route' => 'kit_rbac_user',
                'label' => '管理员列表'
            ]);
            $menu['kit_rbac_user']->addChild('kit_rbac_user_add', [
                'route' => 'kit_rbac_user_add',
                'label' => '新增管理员'
            ]);
            $menu['kit_rbac_user']->addChild('kit_rbac_role', [
                'route' => 'kit_rbac_role',
                'label' => '用户组列表'
            ]);
            $menu['kit_rbac_user']->addChild('kit_rbac_role_add', [
                'route' => 'kit_rbac_role_add',
                'label' => '新增用户组'
            ]);
        }
        
        
        $menu->addChild('kit_news_list', array(
            'route' => 'kit_news_list',
            'label' => '文章',
            'attributes' => [
                'icon' => 'icon-tasks'
            ]
        ));
        $menu['kit_news_list']->addChild('kit_news_list', [
            'route' => 'kit_news_list',
            'label' => '文章列表'
        ]);
        $menu['kit_news_list']->addChild('kit_news_add', [
            'route' => 'kit_news_add',
            'label' => '新增文章'
        ]);
        $menu['kit_news_list']->addChild('kit_news_category', [
            'route' => 'kit_news_category',
            'label' => '分类列表'
        ]);
        $menu['kit_news_list']->addChild('kit_news_category_add', [
            'route' => 'kit_news_category_add',
            'label' => '新增分类'
        ]);
        $menu['kit_news_list']->addChild('kit_news_category_update', [
            'route' => 'kit_news_category_update',
            'label' => '更新分类',
            'attributes' => [
                'show' => 'off'
            ]
//             'routeParameters' => [
//                 'id' => $this->getRequest()->get('id')
//             ]
        ]);
        
        $menu->addChild('kit_video_list', array(
            'route' => 'kit_video_list',
            'label' => '视频',
            'attributes' => [
                'icon' => 'icon-video-camera'
            ]
        ));
        $menu['kit_video_list']->addChild('kit_video_list', [
            'route' => 'kit_video_list',
            'label' => '视频列表'
        ]);
        $menu['kit_video_list']->addChild('kit_video_add', [
            'route' => 'kit_video_add',
            'label' => '上传视频'
        ]);
        
        $menu['kit_video_list']->addChild('kit_video_log', [
            'route' => 'kit_video_log',
            'label' => '视频日志'
        ]);
        $menu['kit_video_list']->addChild('kit_video_edit', [
            'route' => 'kit_video_edit',
            'label' => '日志编辑',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_video_list']->addChild('kit_video_log_show', [
            'route' => 'kit_video_log_show',
            'label' => '日志查看',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_video_list']->addChild('kit_video_show', [
            'route' => 'kit_video_show',
            'label' => '视频查看',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        
        
        $menu->addChild('kit_scene_homepage', array(
            'route' => 'kit_scene_homepage',
            'label' => '案件',
            'attributes' => [
                'icon' => 'icon-anchor'
            ]
        ));
        $menu['kit_scene_homepage']->addChild('kit_scene_homepage', [
            'route' => 'kit_scene_homepage',
            'label' => '案件管理'
        ]);
        $menu['kit_scene_homepage']->addChild('matter_index', [
            'route' => 'matter_index',
            'label' => '案件列表'
        ]);
        $menu['kit_scene_homepage']->addChild('matter_new', [
            'route' => 'matter_new',
            'label' => '立案呈报'
        ]);
        $menu['kit_scene_homepage']->addChild('matter_show', [
            'route' => 'matter_show',
            'label' => '案件详情',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('matter_examine', [
            'route' => 'matter_examine',
            'label' => '案件审批',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('matter_edit', [
            'route' => 'matter_edit',
            'label' => '案件编辑',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('report_index', [
            'route' => 'report_index',
            'label' => '调查报告列表'
        ]);
        $menu['kit_scene_homepage']->addChild('report_new', [
            'route' => 'report_new',
            'label' => '新增调查报告'
        ]);
        $menu['kit_scene_homepage']->addChild('report_show', [
            'route' => 'report_show',
            'label' => '调查报告详情',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('report_examine', [
            'route' => 'report_examine',
            'label' => '调查报告审核',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('notice_index', [
            'route' => 'notice_index',
            'label' => '通知公告'
        ]);
        $menu['kit_scene_homepage']->addChild('notice_new', [
            'route' => 'notice_new',
            'label' => '新增通知公告',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('notice_show', [
            'route' => 'notice_show',
            'label' => '查看通知公告',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        $menu['kit_scene_homepage']->addChild('notice_edit', [
            'route' => 'notice_edit',
            'label' => '编辑通知公告',
            'attributes' => [
                'show' => 'off'
            ]
        ]);
        return $menu;
    }
}