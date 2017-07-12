<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Session\Session;
use Psr\Log\LoggerInterface;

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

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $status = "No te haz registrado correctamente";
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $email = $form->get("email")->getData();
                $exist_user = $em->getRepository("BlogBundle:User")->findOneBy(array('email' => $email));
                if ($exist_user === null) {
                    $user = new User();
                    $user->setName($form->get("name")->getData());
                    $user->setSurname($form->get("surname")->getData());
                    $user->setEmail($email);
                    $user->setRole("ROLE_USER");
                    $user->setImage(null);

                    //Encoding Password
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());
                    $user->setPassword($password);

                    try {
                        $em->persist($user);
                        $flush = $em->flush();
                    } catch (Exception $ex) {
                        $this->_logger->log(100, print_r($ex->getMessage(), true));
                    }
                    if ($flush === null) {
                        $status = "Usuario creado correctamente";
                    }
                } else {
                    $status = "Ya existe usuario con ese email.Intente con otro";
                }
            }
            $this->_session->getFlashBag()->add("status", $status);
        }

        return $this->render("BlogBundle:User:login.html.twig", array(
                    'error' => $error,
                    'last_username' => $lastUsername,
                    'form' => $form->createView()
        ));
    }

}
