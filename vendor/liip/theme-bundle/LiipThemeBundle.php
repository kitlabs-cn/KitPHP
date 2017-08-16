<?php

/*
 * This file is part of the Liip/ThemeBundle
 *
 * (c) Liip AG
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ThemeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Liip\ThemeBundle\DependencyInjection\Compiler\ThemeCompilerPass;
use Liip\ThemeBundle\DependencyInjection\Compiler\TemplateResourcesPass;
use Liip\ThemeBundle\DependencyInjection\Compiler\AsseticTwigFormulaPass;

class LiipThemeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ThemeCompilerPass());
        $container->addCompilerPass(new TemplateResourcesPass());
        $container->addCompilerPass(new AsseticTwigFormulaPass());
    }
}
