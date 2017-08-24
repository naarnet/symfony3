<?php

namespace AdminBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bridge\Monolog\Logger;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserAdminController
 *
 * @author Néstor Alain Arnet Oviedo naarnet10@gmail.com
 */
class UserAdminController extends Controller
{

    /**
     * Function to disable or enable Manager
     */
    public function disableAction()
    {
        $object = $this->admin->getSubject();

        $html = $this->renderView('AdminBundle:User:index.html.twig', array(
            'user' => $object
        ));

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"'
                )
        );
    }

}
