<?php

namespace GestoriaBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bridge\Monolog\Logger;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeAdminController
 *
 * @author Néstor Alain Arnet Oviedo naarnet10@gmail.com
 */
class UserAdminController extends Controller {

        /**
         * Create action.
         *
         * @param Request $request
         *
         * @return Response
         *
         * @throws AccessDeniedException If access is not granted
         */
        public function createAction() {
                $request = $this->getRequest();
                // the key used to lookup the template
                $templateKey = 'edit';

                if (false === $this->admin->isGranted('CREATE')) {
                        throw new AccessDeniedException();
                }

                $object = $this->admin->getNewInstance();

                $this->admin->setSubject($object);

                /** @var $form \Symfony\Component\Form\Form */
                $form = $this->admin->getForm();
                $form->setData($object);

                if ($this->getRestMethod() == 'POST') {
                        $form->submit($request);
                        $em = $this->getDoctrine()->getManager();
                        $userExist = $em->getRepository('AdminBundle:User')->findOneByEmail($object->getEmail());
                        $isFormValid = $form->isValid();
                        // persist if the form was valid and if in preview mode the preview was approved
                        if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved()) && $userExist == null) {
                                if (false === $this->admin->isGranted('CREATE', $object)) {
                                        throw new AccessDeniedException();
                                }
                                try {
                                        $object = $this->admin->create($object);

                                        if ($this->isXmlHttpRequest()) {
                                                return $this->renderJson(array(
                                                            'result' => 'ok',
                                                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                                                                ), 200, array());
                                        }

                                        $this->addFlash(
                                                'sonata_flash_success', $this->admin->trans(
                                                        'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                                                )
                                        );

                                        // redirect to edit mode
                                        return $this->redirectTo($object);
                                } catch (ModelManagerException $e) {
                                        $this->logModelManagerException($e);

                                        $isFormValid = false;
                                }
                        }

                        // show an error message if the form failed validation
                        if (!$isFormValid) {
                                if (!$this->isXmlHttpRequest()) {
                                        $this->addFlash(
                                                'sonata_flash_error', $this->admin->trans(
                                                        'flash_create_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                                                )
                                        );
                                }
                        } elseif ($this->isPreviewRequested()) {
                                // pick the preview template if the form was valid and preview was requested
                                $templateKey = 'preview';
                                $this->admin->getShow();
                        }
                        if ($userExist) {
                                $this->addFlash('sonata_flash_error', 'Ya existe un usuario con ese email. Por favor edite el usuario y agréguele el rol');
                        }
                }

                $view = $form->createView();

                // set the theme for the current Admin Form
                $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

                return $this->render($this->admin->getTemplate($templateKey), array(
                            'action' => 'create',
                            'form' => $view,
                            'object' => $object,
                                ), null);
        }

        /**
         * Edit action.
         *
         * @param int|string|null $id
         *
         * @return Response|RedirectResponse
         *
         * @throws NotFoundHttpException If the object does not exist
         * @throws AccessDeniedException If access is not granted
         */
        public function editAction($id = null) {
                $request = $this->getRequest();
                // the key used to lookup the template
                $templateKey = 'edit';

                $id = $request->get($this->admin->getIdParameter());
                $object = $this->admin->getObject($id);
                $oldEmail = $object->getEmail();
                if (!$object) {
                        throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
                }

                if (false === $this->admin->isGranted('EDIT', $object)) {
                        throw new AccessDeniedException();
                }

                $this->admin->setSubject($object);

                /** @var $form \Symfony\Component\Form\Form */
                $form = $this->admin->getForm();
                $form->setData($object);
                $form->handleRequest($request);

                if ($request->isMethod('POST')) {
                        $isFormValid = $form->isValid();
                        $newEmail = $form->getData()->getEmail();
                        $userExist = null;
                        if ($newEmail != $oldEmail) {
                                $em = $this->getDoctrine()->getManager();
                                $userExist = $em->getRepository('AdminBundle:User')->findOneByEmail($newEmail);
                        }
                        // persist if the form was valid and if in preview mode the preview was approved
                        if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved()) && $userExist == null) {
                                try {
                                        $object = $this->admin->update($object);

                                        if ($this->isXmlHttpRequest()) {
                                                return $this->renderJson(array(
                                                            'result' => 'ok',
                                                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                                                                ), 200, array());
                                        }

                                        $this->addFlash(
                                                'sonata_flash_success', $this->admin->trans(
                                                        'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                                                )
                                        );

                                        // redirect to edit mode
                                        return $this->redirectTo($object);
                                } catch (ModelManagerException $e) {
                                        $this->logModelManagerException($e);

                                        $isFormValid = false;
                                }
                        }

                        // show an error message if the form failed validation
                        if (!$isFormValid) {
                                if (!$this->isXmlHttpRequest()) {
                                        $this->addFlash(
                                                'sonata_flash_error', $this->admin->trans(
                                                        'flash_edit_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                                                )
                                        );
                                }
                        } elseif ($this->isPreviewRequested()) {
                                // enable the preview template if the form was valid and preview was requested
                                $templateKey = 'preview';
                                $this->admin->getShow();
                        }
                        if ($userExist) {
                                $this->addFlash('sonata_flash_error', 'Ya existe un usuario con ese email. Por favor edite el usuario y agréguele el rol Administrativo');
                        }
                }

                $view = $form->createView();

                // set the theme for the current Admin Form
                $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

                return $this->render($this->admin->getTemplate($templateKey), array(
                            'action' => 'edit',
                            'form' => $view,
                            'object' => $object,
                                ), null);
        }

        /**
         * Function to disable or enable Manager
         */
        public function disableAction() {

                $object = $this->admin->getSubject();

                if (!$object) {
                        throw new NotFoundHttpException(sprintf('unable to find the object with id : %s'));
                }
                $message = '';
                if ($object->getActive() == FALSE) {
                        $object->setActive(True);
                        $message = 'El usuario deberá realizar el proceso de recuperación de contraseña para crear sus creedenciales';
                } else {
                        $object->setActive(FALSE);
                        $psswd = substr(md5(microtime()), 1, 8);
                        //Setting password
                        $object->setPassword($psswd);
                        $message = 'El usuario está inhabilitado y no podrá acceder a ningún servicio de tantan.';
                }
                $this->admin->update($object);

                $this->addFlash('sonata_flash_success', $message);

                return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
        }

}
