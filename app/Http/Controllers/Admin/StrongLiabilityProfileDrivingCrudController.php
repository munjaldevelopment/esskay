<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StrongLiabilityProfileDrivingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StrongLiabilityProfileDrivingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StrongLiabilityProfileDrivingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStrongLiabilityProfileDrivingStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitStrongLiabilityProfileDrivingUpdate; }

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
        CRUD::setModel(\App\Models\StrongLiabilityProfileDriving::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/strongliabilityprofiledriving');
        CRUD::setEntityNameStrings('strong liability profile driving', 'strong liability profile drivings');

        $list_strong_liability_profile_driving = backpack_user()->hasPermissionTo('list_strong_liability_profile_driving');
        
        if($list_strong_liability_profile_driving)
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

            $checker_strong_liability_profile_driving = backpack_user()->hasPermissionTo('checker_strong_liability_profile_driving');

            if($checker_strong_liability_profile_driving)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_strong_liability_profile_driving', 'revise', 'delete']);
                }
                else
                {
                    if($checker_strong_liability_profile_driving)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_strong_liability_profile_driving']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_strong_liability_profile_driving', 'revise', 'delete']);
            }

            $this->crud->addColumn([
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Tier1',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Tier2',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'strong_liability_driving_status',
                ]);
                    
            $this->crud->addField([
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Tier1',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Tier2',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);                    

           
            
             $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'select2_from_array',
                    'name'      => 'strong_liability_driving_status',
                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
                ]);
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityDrivingButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityDrivingButton', 'end');

            $this->crud->addButtonFromView('line', 'checker_strong_liability_profile_driving', 'checker_strong_liability_profile_driving', 'end');

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
        CRUD::setValidation(StrongLiabilityProfileDrivingRequest::class);

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

        $result = $this->traitStrongLiabilityProfileDrivingStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitStrongLiabilityProfileDrivingUpdate();

        return $result;
    }
}
