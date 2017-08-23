<?php
namespace KitBaseBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use KitAdminBundle\Service\ThemeService;

class ExceptionController extends BaseController
{
    private $theme;
    
    public function __construct(\Twig_Environment $twig, $debug,ThemeService $theme)
    {
        parent::__construct($twig, $debug);
        $this->theme = $theme;
    }
    /**
     * @param Request $request
     * @param string  $format
     * @param int     $code          An HTTP response status code
     * @param bool    $showException
     *
     * @return string
     */
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        $themeName = $this->theme->get();
        $name = $showException ? 'exception' : 'error';
        if ($showException && 'html' == $format) {
            $name = 'exception_full';
        }
        
        // For themes error pages
        if (!$showException) {
            $template = sprintf('@KitWeb/theme/'.$themeName.'/Exception/%s%s.%s.twig', $name, $code, $format);
            if ($this->templateExists($template)) {
                return $template;
            }
        }
        // try to find a template for the given format
        $template = sprintf('@KitWeb/theme/'.$themeName.'/Exception/%s.%s.twig', $name, $format);
        if ($this->templateExists($template)) {
            return $template;
        }
        return parent::findTemplate($request, $format, $code, $showException);
    }
}