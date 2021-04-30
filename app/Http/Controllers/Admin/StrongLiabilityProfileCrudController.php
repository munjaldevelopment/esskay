<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StrongLiabilityProfileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StrongLiabilityProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StrongLiabilityProfileCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStrongLiabilityProfileStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitStrongLiabilityProfileUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StrongLiabilityProfile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/strongliabilityprofile');
        CRUD::setEntityNameStrings('strong liability profile', 'Strong Liability Profiles');

        $list_strong_liability_profile = backpack_user()->hasPermissionTo('list_strong_liability_profile');
        
        if($list_strong_liability_profile)
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
            
            $this->crud->addColumn([
                    'label'     => 'Quarter',
                    'type'      => 'text',
                    'name'      => 'quarter',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Bank/FI',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'CME From MF',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'strong_liability_status',
                ]);
                    
            $this->crud->addField([
                    'label'     => 'Quarter',
                    'type'      => 'text',
                    'name'      => 'quarter',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bank/FI',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'CME From MF',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Others',
                    'type'      => 'text',
                    'name'      => 'amount3',
                    ]);

            /*$this->crud->addField([
                    'label'     => 'Amount4',
                    'type'      => 'text',
                    'name'      => 'amount4',
                    ]);*/

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'strong_liability_status',
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityButton', 'end');

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
        CRUD::setValidation(StrongLiabilityProfileRequest::class);

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

        $result = $this->traitStrongLiabilityProfileStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitStrongLiabilityProfileUpdate();

        return $result;
    }
}
