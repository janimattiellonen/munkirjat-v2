<?php
namespace MunKirjat\UserBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class SecurityController extends Controller
{
    public function allowedActionsAction()
    {
        $allowedActions = $this->getSecurityService()->getAllowedResources($this->getCurrentUser() );

        return $this->getJsonResponse($allowedActions);
    }

    /**
     * @return \MunKirjat\UserBundle\Service\SecurityService
     */
    public function getSecurityService()
    {
        return $this->get('munkirjat_user.service.security');
    }

    public function newTokenAction()
    {
        $csrf = $this->get('form.csrf_provider');

        return $this->getJsonResponse(array('csrf_token' => $csrf->generateCsrfToken("authenticate") ) );
    }

    public function failureAction()
    {
        $form = $this->container->get('munkirjat_user.login.form');
        $formHandler = $this->container->get('munkirjat_user.login.form.handler');

        return $this->createJsonFormFailureResponse($formHandler->onFailure());
    }

    public function successAction()
    {
        return $this->createJsonSuccessRedirectResponse('mun_kirjat_main_frontpage');
    }
}
