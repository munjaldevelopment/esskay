<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StrongLiabilityProfileWellTableRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StrongLiabilityProfileWellTableCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StrongLiabilityProfileWellTableCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStrongLiabilityProfileTableStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitStrongLiabilityProfileTableUpdate; }

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
        CRUD::setModel(\App\Models\StrongLiabilityProfileWellTable::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/strongliabilityprofilewelltable');
        CRUD::setEntityNameStrings('strong liability profile welltable', 'strong liability profile well tables');

        $list_strong_liability_profile_well_table = backpack_user()->hasPermissionTo('list_strong_liability_profile_well_table');
        
        if($list_strong_liability_profile_well_table)
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

            $checker_strong_liability_profile_well_table = backpack_user()->hasPermissionTo('checker_strong_liability_profile_well_table');

            if($checker_strong_liability_profile_well_table)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_strong_liability_profile_well_table', 'revise', 'delete']);
                }
                else
                {
                    if($checker_strong_liability_profile_well_table)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_strong_liability_profile_well_table']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_strong_liability_profile_well_table', 'revise', 'delete']);
            }

            $this->crud->addColumn([
                    'label'     => 'Particulars',
                    'type'      => 'text',
                    'name'      => 'particulars',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'As per IGAAP FY16',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'As per IGAAP FY17',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'strong_liability_well_status',
                ]);
                    
            $this->crud->addField([
                    'label'     => 'Particulars',
                    'type'      => 'text',
                    'name'      => 'particulars',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IGAAP FY16',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IGAAP FY17',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IGAAP FY18',
                    'type'      => 'text',
                    'name'      => 'amount3',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IND AS FY16',
                    'type'      => 'text',
                    'name'      => 'amount4',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IND AS FY17',
                    'type'      => 'text',
                    'name'      => 'amount5',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IGAAP FY18',
                    'type'      => 'text',
                    'name'      => 'amount6',
                    ]);

            $this->crud->addField([
                    'label'     => 'As per IGAAP FY21',
                    'type'      => 'text',
                    'name'      => 'amount7',
                    ]);

            

             $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'select2_from_array',
                    'name'      => 'strong_liability_well_status',
                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityWellTableButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityWellTableButton', 'end');

            $this->crud->addButtonFromView('line', 'checker_strong_liability_profile_well_table', 'checker_strong_liability_profile_well_table', 'end');

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
        CRUD::setValidation(StrongLiabilityProfileWellTableRequest::class);

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

        $result = $this->traitStrongLiabilityProfileTableStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitStrongLiabilityProfileTableUpdate();

        return $result;
    }
}
