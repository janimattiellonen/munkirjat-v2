<?php
namespace MunKirjat\UserBundle\Service;

use FOS\UserBundle\Model\UserInterface;

use MunKirjat\UserBundle\Service\Exception\InvalidUserResourceException;

class SecurityService
{
    /**
     * @param UserInterface|string $user
     *
     * @return array
     */
    public function getAllowedResources($user)
    {
        $allowed = array(
            'frontpage'     => '/#frontpage',
            'about'         => '/#about',
            'list-authors'  => '/#authors',
            'list-genres'   => '/#genres',
            'list-books'    => '/#books',
            'statistics'    => '',
            'search'        => '/#search',
            'view-book'     => '/#book/:id'
        );

        $loggedOut = array(
            'login'         => '/#login',
        );

        $protected = array(
            'add-new-author'    => '/#author',
            'add-new-book'      => '/#book',
            'add-new-genre'     => '/#genre',
            'logout'            => '/#logout',
        );

        if(is_string($user) )
        {
            return array('logged-in' => false, 'data' => array_merge($allowed, $loggedOut) );
        }
        else if($user instanceof UserInterface)
        {
            return array('logged-in' => true, 'data' => array_merge($allowed, $protected) );
        }
    }
}
