<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller
{

    private $_session;
    protected $_logger;

    public function __construct()
    {
        $this->_session = new Session();
    }

    public function indexAction()
    {
        var_dump($this->get('translator')->trans("btn_edit"));
        $em = $this->getDoctrine()->getManager();
        $categories_repo = $em->getRepository('BlogBundle:Category');
        $entries_repo = $em->getRepository('BlogBundle:Entry');
        $entries = $entries_repo->findAll();
        $categories = $categories_repo->findAll();
        return $this->render("BlogBundle:Category:index.html.twig", array(
                    'categories' => $categories,
                    'entries' => $entries
        ));
    }

    public function addAction(Request $request)
    {
        $this->_logger = $this->get('logger');
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $category = new Category();
                $category->setName($form->get('name')->getData());
                $category->setDescription($form->get('description')->getData());

                try {
                    $em->persist($category);
                    $em->flush();
                    $status = "Se ha agregado correctamente!!!";
                } catch (\Exception $ex) {
                    $this->_logger->log(100, print_r($ex->getMessage(), true));
                    $status = "Ha ocurrido un error al añadir la categoría!!!";
                }
            } else {
                $status = "Formulario no es válido!!!";
            }
            $this->_session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute('blog_index_category');
        }

        return $this->render("BlogBundle:Category:add.html.twig", array(
                    'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $this->_logger = $this->get('logger');
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $category_repo = $em->getRepository('BlogBundle:Category');
            $category = $category_repo->find($id);

            try {
                $em->remove($category);
                $em->flush();
                $status = "Se ha eliminado con éxito!!!";
            } catch (\Exception $ex) {
                $this->_logger->debug($ex->getMessage());
                $status = "No se puede eliminar!!!";
            }
            $this->_session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute('blog_index_category');
        }
    }

    public function editAction(Request $request, $id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $category_repo = $em->getRepository('BlogBundle:Category');
            $category = $category_repo->find($id);

            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {

                if ($form->isValid()) {

                    $category->setName($form->get('name')->getData());
                    $category->setDescription($form->get('description')->getData());

                    try {
                        $em->persist($category);
                        $em->flush();
                        $status = "Se ha editado correctamente!!!";
                    } catch (\Exception $ex) {
                        $this->_logger->log(100, print_r($ex->getMessage(), true));
                        $status = "Ha ocurrido un error al editar la categoría!!!";
                    }
                } else {
                    $status = "La categoría no se ha editado!!!";
                }
                $this->_session->getFlashBag()->add('status', $status);
                return $this->redirectToRoute('blog_index_category');
            }
            return $this->render("BlogBundle:Category:edit.html.twig", array(
                        'form' => $form->createView()
            ));
        }
    }

}
