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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;
use Sonata\AdminBundle\Route\RouteCollection;
use Addressable\Bundle\Form\Type\AddressMapType;

class WorkAdmin extends Admin
{

    public $baseRouteName = null;
    protected $translationDomain = 'SonataUserBundle';

    /**
     * Route to action disable
     * @param RouteCollection $collection
     */
//    protected function configureRoutes(RouteCollection $collection)
//    {
//        $collection->add('disable', $this->getRouterIdParameter() . '/disable');
//    }

    /**
     * Form View for User Entity 
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {


        $formMapper
                ->add('name', 'text', array('label' => 'Name'))->end();
        $formMapper->with('Location')
                ->add('address', AddressMapType::class, array(
                    'google_api_key' => 'AIzaSyCIqWO_Za2ilOovmezL0fYsG5mQKpYPt4c',
                    'default_lat' => 19.4187665, // the starting position on the map
                    'default_lng' => -99.1629519, // the starting position on the map
                    'include_current_position_action' => true, // whether to include the set current position button
                ))
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
                ->add('streetName', null, array('label' => 'Calle'))
                ->add('streetNumber', null, array('label' => 'Número exterior'))
                ->add('zipCode', null, array('label' => 'Código Postal'));
    }

    /**
     * Display Show View
     * 
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('streetName', null, array('label' => 'Calle'))
                ->add('streetNumber', null, array('label' => 'Número exterior'))
                ->add('zipCode', null, array('label' => 'Código Postal'));
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
                ->add('streetName', null, array('label' => 'Calle'))
                ->add('streetNumber', null, array('label' => 'Número exterior'))
                ->add('zipCode', null, array('label' => 'Código Postal'))
                ->add('_action', 'actions', array(
                    'label' => 'Acciones',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
//                        'disable' => array(
//                            'template' => 'AdminBundle:CRUD:list__action_disable.html.twig'),
                        'delete' => array(),)));
    }

}
