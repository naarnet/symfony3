<?php

/**
 * Description of UserAdmin
 *
 * @author naarnet10@gmail.com
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
//use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends Admin
{

    public $baseRouteName = null;
    protected $translationDomain = 'SonataUserBundle';

    /**
     * Route to action disable
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('disable', $this->getRouterIdParameter() . '/disable');
    }

    /**
     * Form View for User Entity 
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {


        $formMapper
                ->with('Datos Personales', array(
                    'class' => 'col-md-6',
                    'box_class' => 'box box-solid box-danger',
                    'description' => 'La contraseña debe ser de 6 dígitos',))
                ->add('name', 'text', array('label' => 'Name'))
                ->add('lastname', 'text', array('label' => 'Apellidos'))
                ->add('email', 'email', array('label' => 'Correo Electrónico'))
                ->end();
        $formMapper
                ->with('Credenciales', array(
                    'class' => 'col-md-6',
                    'box_class' => 'box box-solid box-danger',
                    'description' => 'La contraseña debe ser de 6 dígitos',))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'required' => true,
                    'first_options' => array('label' => 'Contraseña'),
                    'second_options' => array('label' => 'Confirmación de Contraseña'),))
                ->add('user_roles', null, array(
                    'label' => 'Rol',
                    'required' => true,
                    'help' => 'Por favor asigne un Rol'))
                ->end();
    }

    /**
     * Display Filters
     * 
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('lastName', null, array('label' => 'Apellidos'))
                ->add('email', null, array('label' => 'Correo Electrónico'))
                ->add('user_roles', null, array('label' => 'Rol'), 'entity', array(
                    'class' => 'GestoriaBundle\Entity\Role'
        ));
    }

    /**
     * Display Show View
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $showMapper
                ->add('image', 'string', array(
                    'template' => 'AdminBundle:Default:show_image.html.twig'))
                ->add('name', null, array('label' => 'Nombre'))
                ->add('lastName', null, array('label' => 'Apellidos'))
                ->add('email', null, array('label' => 'Correo Electrónico'))
                ->add('user_roles', null, array('label' => 'Rol'));
    }

    /**
     * Display List View
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
                ->add('name', null, array('label' => 'Nombre'))
                ->add('lastname', null, array('label' => 'Apellidos'))
                ->add('email', 'email', array('label' => 'Correo Electrónico'))
                ->add('user_roles', null, array('label' => 'Rol'))
                ->add('_action', 'actions', array(
                    'label' => 'Acciones',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'disable' => array(
                            'template' => 'AdminBundle:CRUD:list__action_disable.html.twig'),
                        'delete' => array(),)));
    }

}
