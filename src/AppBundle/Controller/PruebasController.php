<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use AppBundle\Form\CursoType;
use AppBundle\Entity\Curso;
use Symfony\Component\Validator\Constraints as Assert;

class PruebasController extends Controller
{

    protected $_logger;

    public function indexAction(Request $request, $name, $page)
    {
        $this->_logger = $this->get('logger');

        $productos = array(array('producto' => 'Consola', 'precio' => 2),
            array('producto' => 'Pc', 'precio' => 4),
            array('producto' => 'Monitor', 'precio' => 6),
            array('producto' => 'Refri', 'precio' => 8)
        );
        return $this->render('AppBundle:pruebas:index.html.twig', array(
                    'text' => $name . '-' . $page,
                    'productos' => $productos
        ));
    }

    public function createAction()
    {
        $curso = new Curso();
        $curso->setTitulo('Curso de Cakephp3');
        $curso->setDescription("Curso Completo de Cakephp3");
        $curso->setPrecio(80);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($curso);
        $flush = $em->flush();
        if ($flush !== null) {
            echo "El curso no se ha creado bien";
        } else {
            echo 'dddd';
            echo "Se ha creado correctamente";
        }
        die();
    }

    public function readAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repository = $em->getRepository("AppBundle:Curso");
        $cursos = $cursos_repository->findOneBy(array('id' => 3));

        echo $cursos->getTitulo() . "<br>";
//        foreach ($cursos as $curso) {
//            echo $curso->getDescription() . "<br>";
//            echo $curso->getPrecio() . "<br>";
//        }
        die('hola');
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repository = $em->getRepository("AppBundle:Curso");
        $curso = $cursos_repository->find($id);
        $curso->setTitulo('Visca Barca');
        $em->persist($curso);
        $flush = $em->flush();
        if ($flush !== null) {
            echo 'No se ha actualizado';
        } else {
            echo 'Updated';
        }
        die('hola1 Ronaldinho');
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repository = $em->getRepository("AppBundle:Curso");
        $curso = $cursos_repository->find($id);

        $em->remove($curso);
        $flush = $em->flush();
        if ($flush !== null) {
            echo 'No se ha Eliminado';
        } else {
            echo 'Eliminado';
        }
        die('Delete');
    }

    public function nativeSqlAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $curso_repository = $em->getRepository("AppBundle:Curso");
//        $db = $em->getConnection();
//        $query = "Select * from cursos";
//        $stmt = $db->prepare($query);
//        $params = array();
//        $stmt->execute($params);
//        
//        $cursos = $stmt->fetchAll();precio
//        $query = $em->createQuery(
//                "Select c from AppBundle:Curso c where c.precio > :precio"
//        )->setParameter("precio", "79");
//        $cursos = $query->getResult();


        $cursos = $curso_repository->getCursos();
        foreach ($cursos as $curso) {

            echo $curso->getTitulo();
        }
        die('Dql');
    }

    public function createFormAction(Request $request)
    {
        $curso = new Curso();
        $form = $this->createForm(CursoType::class, $curso);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $status = "Formulario válido";
            $data = array(
                'titulo' => $form->get("titulo")->getData(),
                'descripcion' => $form->get("description")->getData(),
                'precio' => $form->get("precio")->getData()
            );
        } else {
            $status = null;
            $data = null;
        }

        return $this->render('AppBundle:pruebas:form.html.twig', array(
                    'form' => $form->createView(),
                    'status' => $status,
                    'data' => $data
        ));
    }

    public function validateEmailAction($email)
    {
        $emailConstraint = new Assert\Email();
        $emailConstraint->message = "Pásame un buen correo";

        $error = $this->get("validator")->validate(
                $email, $emailConstraint
        );

        if (count($error) === 0) {
            echo 'Correo Válido';
        } else {
            echo $error[0]->getMessage();
        }
        die('hola');
    }

}
