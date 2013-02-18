<?php
namespace MunKirjat\Component\Controller;

use Xi\Bundle\AjaxBundle\Controller\JsonResponseController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends JsonResponseController
{
    /**
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getJsonResponse(array $data = array() )
    {
        return new JsonResponse($data);
    }

    /**
     * @return \FOS\UserBundle\Model\UserInterface|string
     */
    public function getCurrentUser()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return $user;
    }
}
