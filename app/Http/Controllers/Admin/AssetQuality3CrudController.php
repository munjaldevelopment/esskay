<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AssetQuality3Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AssetQuality3CrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AssetQuality3CrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitAssetQuality3Store; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitAssetQuality3Update; }

    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\AssetQuality3::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/asset_quality3');
        CRUD::setEntityNameStrings('Asset Quality3', 'Asset Quality3');

        $list_asset_quality3 = backpack_user()->hasPermissionTo('list_asset_quality3');
        
        if($list_asset_quality3)
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

            $checker_asset_quality3 = backpack_user()->hasPermissionTo('checker_asset_quality3');

            if($checker_asset_quality3)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_asset_quality3', 'revise', 'delete']);
                }
                else
                {
                    if($checker_asset_quality3)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_asset_quality3']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_asset_quality3', 'revise', 'delete']);
            }

            $this->crud->addColumn([
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Amount1',
                    'type'      => 'text',
                    'name'      => 'amount_graph1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Amount2',
                    'type'      => 'text',
                    'name'      => 'amount_graph2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'capital_infusion_status',
                ]);
                    
            $this->crud->addField([
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount1',
                    'type'      => 'text',
                    'name'      => 'amount_graph1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount2',
                    'type'      => 'text',
                    'name'      => 'amount_graph2',
                    ]); 

            $this->crud->addField([
                    'label'     => 'Amount3',
                    'type'      => 'text',
                    'name'      => 'amount_graph3',
                    ]);                    

           
            
             $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'select2_from_array',
                    'name'      => 'capital_infusion_status',
                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
                ]);
            //$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityDrivingButton', 'end');
            //$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityDrivingButton', 'end');

            //$this->crud->addButtonFromView('line', 'checker_asset_quality3', 'checker_asset_quality3', 'end');

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
        CRUD::setValidation(AssetQuality3Request::class);

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

        $result = $this->traitAssetQuality3Store();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitAssetQuality3Update();

        return $result;
    }
}
