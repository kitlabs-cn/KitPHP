<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Tests\Extension;

use Symfony\Bridge\Twig\Extension\HttpKernelExtension;
use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

class HttpKernelExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Twig_Error_Runtime
     */
    public function testFragmentWithError()
    {
        $renderer = $this->getFragmentHandler($this->throwException(new \Exception('foo')));

        $this->renderTemplate($renderer);
    }

    public function testRenderFragment()
    {
        $renderer = $this->getFragmentHandler($this->returnValue(new Response('html')));

        $response = $this->renderTemplate($renderer);

        $this->assertEquals('html', $response);
    }

    public function testUnknownFragmentRenderer()
    {
        $context = $this->getMockBuilder('Symfony\\Component\\HttpFoundation\\RequestStack')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $renderer = new FragmentHandler($context);

        $this->setExpectedException('InvalidArgumentException', 'The "inline" renderer does not exist.');
        $renderer->render('/foo');
    }

    protected function getFragmentHandler($return)
    {
        $strategy = $this->getMock('Symfony\\Component\\HttpKernel\\Fragment\\FragmentRendererInterface');
        $strategy->expects($this->once())->method('getName')->will($this->returnValue('inline'));
        $strategy->expects($this->once())->method('render')->will($return);

        $context = $this->getMockBuilder('Symfony\\Component\\HttpFoundation\\RequestStack')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $context->expects($this->any())->method('getCurrentRequest')->will($this->returnValue(Request::create('/')));

        $renderer = new FragmentHandler($context, array($strategy), false);

        return $renderer;
    }

    protected function renderTemplate(FragmentHandler $renderer, $template = '{{ render("foo") }}')
    {
        $loader = new \Twig_Loader_Array(array('index' => $template));
        $twig = new \Twig_Environment($loader, array('debug' => true, 'cache' => false));
        $twig->addExtension(new HttpKernelExtension());

        $loader = $this->getMock('Twig_RuntimeLoaderInterface');
        $loader->expects($this->any())->method('load')->will($this->returnValueMap(array(
            array('Symfony\Bridge\Twig\Extension\HttpKernelRuntime', new HttpKernelRuntime($renderer)),
        )));
        $twig->addRuntimeLoader($loader);

        return $twig->render('index');
    }
}
