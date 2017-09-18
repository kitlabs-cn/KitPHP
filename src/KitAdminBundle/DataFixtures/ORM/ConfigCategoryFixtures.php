<?php
namespace KitAdminBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use KitAdminBundle\Entity\ConfigCategory;

class ConfigCategoryFixtures extends Fixture
{
    /**
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
     */
    public function load(ObjectManager $manager)
    {
        $createAt = new \DateTime();
        foreach ($this->getConfigCategoryList() as $val){
            $configCategory = new ConfigCategory();
            $configCategory->setName($val['name']);
            $configCategory->setTitle($val['title']);
            $configCategory->setFieldType($val['type']);
            $configCategory->setStatus(1);
            $configCategory->setIp('127.0.0.1');
            $configCategory->setCreateAt($createAt);
            $configCategory->setUpdateAt($createAt);
            $manager->persist($configCategory);
        }
        $manager->flush();
    }
    /**
     * 
     * @return string[]
     */
    private function getConfigCategoryList()
    {
        // 1 文字； 2图片，3视频
        return [
            ['name' => 'screen_bg', 'title' => '首页每屏的背景图', 'type' => 2],
            ['name' => 'videos', 'title' => '首页的三个视频', 'type' => 3],
            ['name' => 'art_font_image', 'title' => '首页的三个艺术字（图片）', 'type' => 2],
            ['name' => 'art_font_word', 'title' => '首页的三个艺术字下的三句话', 'type' => 1],
            ['name' => 'download_title', 'title' => 'APP下载标题', 'type' => 1],
            ['name' => 'download_introduce', 'title' => 'APP下载简介', 'type' => 1],
            ['name' => 'download_qrcode', 'title' => 'APP下载二维码', 'type' => 2],
            ['name' => 'download_ios', 'title' => 'APP下载地址(ios版)', 'type' => 1],
            ['name' => 'download_android', 'title' => 'APP下载地址(Android版)', 'type' => 1],
            ['name' => 'qq_code', 'title' => '客服QQ', 'type' => 1],
            ['name' => 'bottom_introduce', 'title' => '底部简介', 'type' => 1],
            ['name' => 'icp_code', 'title' => 'ICP备案号', 'type' => 1],
            ['name' => 'email_code', 'title' => '邮箱', 'type' => 1],
            ['name' => 'second_title', 'title' => '第二屏小标题', 'type' => 1],
            ['name' => 'second_word', 'title' => '第二屏文字介绍', 'type' => 1],
            ['name' => 'second_image', 'title' => '第二屏选中时图片', 'type' => 2],
        ];
    }
}