<?php
namespace KitWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    /**
     * 
     * @return string
     */
    protected function getTheme($default = 'Default')
    {
        /**
         * @var \KitAdminBundle\Service\ThemeService $themeService
         */
        $themeService = $this->get('kit_admin.theme_service');
        return $themeService->get($default);
    }
    /**
     * 
     * {@inheritDoc}
     * @see \Symfony\Bundle\FrameworkBundle\Controller\Controller::render()
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $basic = $this->getDoctrine()->getRepository('KitAdminBundle:BasicSetting')->basicRepo();
        
        $theme = $this->getTheme();
        
        if(strpos($view, ':')){
            $views = explode(':', $view);
            if(isset($views[1])){
                $views[1] = 'theme/' . $theme . '/' . $views[1];
                $view = implode(':', $views);
            }
        }
        
        $parameters = array_merge([
            'basic' => $basic,
            'theme' => $theme
        ], $parameters);
        
        return parent::render($view, $parameters, $response);
    }
}