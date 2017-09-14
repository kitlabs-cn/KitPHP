<?php 
namespace KitApiBundle\Controller\V1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->json([
            'code' => 1,
            'msg' => 'V1'
        ]);
    }
}