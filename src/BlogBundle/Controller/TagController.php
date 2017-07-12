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

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tags_repo = $em->getRepository('BlogBundle:Tag');
        $tags = $tags_repo->findAll();
        return $this->render("BlogBundle:Tag:index.html.twig", array(
                    'tags' => $tags
        ));
    }

    public function addTagAction(Request $request)
    {
        $this->_logger = $this->get('logger');
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $tag = new Tag();
                $tag->setName($form->get('name')->getData());
                $tag->setDescription($form->get('description')->getData());

                try {
                    $em->persist($tag);
                    $em->flush();
                    $status = "Se ha añadido correctamente!!!";
                } catch (\Exception $ex) {
                    $this->_logger->log(100, print_r($ex->getMessage(), true));
                    $status = "Ha ocurrido un error al añadir la etiqueta!!!";
                }
            } else {
                $status = "Formulario no es válido!!!";
            }
            $this->_session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute('blog_index_tag');
        }

        return $this->render("BlogBundle:Tag:add.html.twig", array(
                    'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $this->_logger = $this->get('logger');
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $tags_repo = $em->getRepository('BlogBundle:Tag');
            $tag = $tags_repo->find($id);

            try {
                $em->remove($tag);
                $em->flush();
                $status = "Se ha eliminado con éxito!!!";
            } catch (\Exception $ex) {
                $this->_logger->debug($ex->getMessage());
                $status = "No se puede eliminar!!!";
            }
            $this->_session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute('blog_index_tag');
        }
    }

}
