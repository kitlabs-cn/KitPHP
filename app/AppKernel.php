<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new KitBaseBundle\KitBaseBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new EightPoints\Bundle\GuzzleBundle\GuzzleBundle(),
            new KitAdminBundle\KitAdminBundle(),
            new KitNewsBundle\KitNewsBundle(),
            new KitWebBundle\KitWebBundle(),
            new KitRbacBundle\KitRbacBundle(),
            new Kit\Bundle\OssBundle\KitOssBundle(),
            new Liip\ThemeBundle\LiipThemeBundle(),
            new Kit\Bundle\PayBundle\KitPayBundle(),
            new KitApiBundle\KitApiBundle(),
            new Kit\TablePrefixBundle\KitTablePrefixBundle(),
            new Kit\CryptBundle\KitCryptBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
