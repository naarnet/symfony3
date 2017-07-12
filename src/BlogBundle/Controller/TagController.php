<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Session\Session;

class TagController extends Controller
{

    private $_session;
    protected $_logger;

    public function __construct()
    {
        $this->_session = new Session();
    }

    public function addTagAction(Request $request)
    {
        $this->_logger = $this->get('logger');
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $status = "Se agregó correctamente!!!";
            } else {
                $status = "Formulario no es válido!!!";
            }
            $this->_session->getFlashBag()->add('status', $status);
        }

        return $this->render("BlogBundle:Tag:add.html.twig", array(
                    'form' => $form->createView()
        ));
    }

}
