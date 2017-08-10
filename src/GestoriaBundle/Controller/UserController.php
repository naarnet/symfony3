<?php

namespace GestoriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GestoriaBundle\Entity\User;
use GestoriaBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{

    private $_session;
    protected $_logger;

    public function __construct()
    {
        $this->_session = new Session();
    }

    public function loginAction(Request $request)
    {
        $this->_logger = $this->get('logger');
        
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("GestoriaBundle:User:login.html.twig", array(
                    'error' => $error,
                    'last_username' => $lastUsername
        ));
    }
    
    /**
         * Check the security 
         *
         * 
         *
         * @return 
         */
        public function securityCheckAction() {

                // The security layer will intercept this request
        }

        /**
         * Logout 
         *
         *
         * @return message
         */
        public function logoutAction() {
                
        }

}
