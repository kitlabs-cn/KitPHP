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
    protected function getTheme()
    {
        return 'default';
    }
    /**
     * 
     * {@inheritDoc}
     * @see \Symfony\Bundle\FrameworkBundle\Controller\Controller::render()
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $theme = $this->getTheme();
        if(strpos($view, ':')){
            $views = explode(':', $view);
            if(isset($views[1])){
                $views[1] = $theme . '/';
            }
        }
        $parameters = array_merge($parameters, [
            'theme' => $theme
        ]);
        return $this->render($view, $parameters, $response);
    }
}