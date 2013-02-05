<?php
namespace MunKirjat\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MunKirjatMainBundle:Default:index.html.twig');
    }
}
