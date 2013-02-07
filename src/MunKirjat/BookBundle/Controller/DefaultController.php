<?php
namespace MunKirjat\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        die("LUSS");
    }

    public function viewAction($id)
    {
        die('Book id: ' . $id);
    }
}
