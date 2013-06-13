<?php
namespace MunKirjat\Component\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

class Controller extends FOSRestController
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

    /**
     * @param mixed $response
     * @return array
     */
    public function createJsonSuccessResponse($response = null)
    {
        return $this->createResponseFor('success', $response);
    }

    /**
     * @param string $route
     * @param array $options  (key value pairs for route parameters)
     * @return array
     */
    public function createJsonSuccessRedirectResponse($route,
                                                      array $options = array()
    ) {
        return $this->createJsonSuccessResponse(array(
            'redirect' => $this->generateUrl($route, $options),
        ));
    }

    /**
     * @return array
     */
    public function createJsonSuccessReloadResponse()
    {
        return $this->createJsonSuccessResponse(array('reload' => true));
    }

    /**
     * Returns a response with success -status, content and callback that should
     * be called in your javascript file.
     *
     * @param string $content
     * @param string $callback
     * @return array
     */
    public function createJsonSuccessWithContent($content, $callback)
    {
        return $this->createResponseFor('success', array(
            'content' => $content, 'callback' => $callback
        ));
    }

    /**
     * @param mixed $response
     * @return array
     */
    public function createJsonFailureResponse($response = null)
    {
        return $this->createResponseFor('failure', $response);
    }

    /**
     * @param Form $form
     * @return array
     */
    public function createJsonFormFailureResponse(Form $form)
    {
        return $this->createJsonFailureResponse(array(
            'formErrors' => $this->getFormErrorsForJson($form),
        ));
    }

    /**
     * Gets form errors for interoperability with javascript AjaxForm.
     *
     * @param Form $form
     * @return array
     */
    public function getFormErrorsForJson(Form $form)
    {
        $errors = array();
        $translator = $this->get('translator');

        $formName = $form->getName();
        $formName = !empty($formName) ? $formName : 'defaultForm';

        if (count($form->getErrors())) {
            foreach ($form->getErrors() as $error) {
                $errors[$formName]['errors'][] = $translator->trans(
                    $error->getMessageTemplate(),
                    $error->getMessageParameters()
                );
            }
        }

        if ($form->count()) {
            foreach ($form->all() as $child) {
                if ($child->count()) {
                    if ($childErrors = $this->getFormErrorsForJson($child)) {
                        $errors[$formName]['childErrors'] = array_merge_recursive(
                            isset($errors[$formName]['childErrors'])
                                ? $errors[$formName]['childErrors']
                                : array(),
                            $childErrors
                        );
                    }
                } else if (count($child->getErrors())) {
                    $errors[$formName]['childErrors'][$child->getName()] = array_map(function($error) use ($translator) {
                        return $translator->trans($error->getMessageTemplate(), $error->getMessageParameters());
                    }, $child->getErrors());
                }
            }
        }

        return $errors;
    }

    /**
     * @param string $what
     * @param mixed $response
     * @return array
     */
    private function createResponseFor($what, $response = null)
    {
        return array('jsonresponse' => array(
            $what => $response === null ? true : $response,
        ));
    }

    /**
     * Processes a form and executes and returns the result of either success or
     * failure callback.
     *
     * @param  Form     $form
     * @param  callback $successCallback
     * @param  callback $failureCallback
     * @return mixed
     */
    protected function processForm(Form $form, $successCallback,
                                   $failureCallback = null)
    {
        if($form->bind($this->getRequest())->isValid()) {
            return $successCallback($form);
        }

        $self = $this;
        $failureCallback = $failureCallback ?: function($form) use ($self) {
            return $self->createJsonFormFailureResponse($form);
        };

        return $failureCallback($form);
    }

    /**
     * Removes the 'id' value if found during an XmlHttpRequest (PUT).
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        $request = parent::getRequest();

        if($request->isXmlHttpRequest() && $request->isMethod('PUT') )
        {
            $request->request->remove('id');
        }

        return $request;
    }
}
