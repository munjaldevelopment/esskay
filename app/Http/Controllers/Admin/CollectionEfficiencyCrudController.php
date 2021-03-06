<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CollectionEfficiencyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CollectionEfficiencyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CollectionEfficiencyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitCollectionEfficiencyStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitCollectionEfficiencyUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\ReviseOperation\ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CollectionEfficiency::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/collection_efficiency');
        CRUD::setEntityNameStrings('Collection Efficiency', 'Collection Efficiencies');

        $list_collection_efficiency = backpack_user()->hasPermissionTo('list_collection_efficiency');
        
        if($list_collection_efficiency)
        {
            $adminRolesRow  = \DB::table('model_has_roles')->where('role_id', '=', '1')->get();
            
            $adminRolesData = array();
            foreach($adminRolesRow as $row)
            {
                $adminRolesData[] = $row->model_id;
            }
            
            $this->crud->orderBy('updated_at', 'DESC');
            
            
            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();

            $checker_collection_efficiency = backpack_user()->hasPermissionTo('checker_collection_efficiency');

            if($checker_collection_efficiency)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_collection_efficiency', 'revise', 'delete']);
                }
                else
                {
                    if($checker_collection_efficiency)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_collection_efficiency']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_collection_efficiency', 'revise', 'delete']);
            }
            
            $this->crud->addColumn([
                    'label'     => 'Heading Top',
                    'type'      => 'text',
                    'name'      => 'heading_graph1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Amount Top',
                    'type'      => 'text',
                    'name'      => 'amount_graph1',
                    ]);

            $this->crud->addColumn([
                     'label'     => 'Heading Bottom',
                    'type'      => 'text',
                    'name'      => 'heading_graph2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Amount Bottom',
                    'type'      => 'text',
                    'name'      => 'amount_graph2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Heading Top Graph',
                    'type'      => 'text',
                    'name'      => 'heading_graph1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Top Graph',
                    'type'      => 'text',
                    'name'      => 'amount_graph1',
                    ]);

            $this->crud->addField([
                     'label'     => 'Heading Bottom Graph',
                    'type'      => 'text',
                    'name'      => 'heading_graph2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Bottom Graph',
                    'type'      => 'text',
                    'name'      => 'amount_graph2',
                    ]);

            
            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'select2_from_array',
                    'name'      => 'collection_efficiency_status',
                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportCollectionEfficiencyButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importCollectionEfficiencyButton', 'end');

             $this->crud->addButtonFromView('line', 'checker_collection_efficiency', 'checker_collection_efficiency', 'end');

            $this->crud->setCreateView('admin.create-lender-banking-form');
            $this->crud->setUpdateView('admin.edit-lender-banking-form');
        }
        else
        {
            $this->crud->denyAccess(['list']);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CollectionEfficiencyRequest::class);

        CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitCollectionEfficiencyStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitCollectionEfficiencyUpdate();

        return $result;
    }
}
