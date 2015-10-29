<?php

namespace Bfvt\AreaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Bfvt\AreaBundle\Entity\Area;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

class AreaAdmin extends Admin
{
    protected $baseRouteName = 'sonata_area'; //shourter routes
    protected $baseRoutePattern = 'area'; //shorter url

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->remove('export');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Post')
                ->with('First')
                    ->add('name')
                    ->add('date', 'sonata_type_datetime_picker', array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => false,
                        'dp_use_seconds'        => false,
                    ))
                ->end()
            ->end()
            ->tab('Options')
                ->with('Second')
                    ->add('location', null, array('help'=>'Elég csak úgy nagyjából'))
                    ->add('details')
                ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('date')
            ->add('location')
            ->add('details', null, array('editable' => true))
            ->add('_action','action', array(
                'actions' => array(
                    'delete' => array(),
                    'show' => array()
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('date')
            ->add('location')
        ;
    }

    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'DESC', // reverse order (default = 'ASC')
        '_sort_by' => 'name'  // name of the ordered field
        // (default = the model's id field, if any)

        // the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
    );


    public function toString($object)
    {
        return $object instanceof Area
            ? $object->getName()
            : 'Area'; // shown in the breadcrumb on the create view
    }
}