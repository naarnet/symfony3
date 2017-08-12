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

class RoleAdmin extends Admin
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
                ->add('name', null, array('label' => 'Name'))
                ->add('alias', 'text', array('label' => 'Alias'))
                ->add('description', 'text', array('label' => 'Description'))
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
                ->add('alias', null, array('label' => 'Alias'))
                ->add('description', null, array('label' => 'Description'))
        ;
    }

    /**
     * Display Show View
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $showMapper
                ->add('name', null, array('label' => 'Nombre'))
                ->add('alias', 'text', array('label' => 'Alias'))
                ->add('description', 'text', array('label' => 'Description'))
        ;
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
                ->add('alias', null, array('label' => 'Alias'))
                ->add('description', null, array('label' => 'Description'))
                ->add('_action', 'actions', array(
                    'label' => 'Acciones',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),)));
    }

}
