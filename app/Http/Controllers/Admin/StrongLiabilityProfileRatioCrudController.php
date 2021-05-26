<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StrongLiabilityProfileRatioRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StrongLiabilityProfileRatioCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StrongLiabilityProfileRatioCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStrongLiabilityProfileRatioStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitStrongLiabilityProfileRatioUpdate; }

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
        CRUD::setModel(\App\Models\StrongLiabilityProfileRatio::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/strongliabilityprofileratio');
        CRUD::setEntityNameStrings('strong liability profile ratio', 'strong liability profile ratios');

        $list_strong_liability_profile_ratio = backpack_user()->hasPermissionTo('list_strong_liability_profile_ratio');
        
        if($list_strong_liability_profile_ratio)
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
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Branches',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Employee Strength',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'strong_liability_ratio_status',
                ]);
                    
            $this->crud->addField([
                    'label'     => 'Financial Year',
                    'type'      => 'text',
                    'name'      => 'financial_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Branches',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Employee Strength',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);                    

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'strong_liability_ratio_status',
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityRatioButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityRatioButton', 'end');

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
        CRUD::setValidation(StrongLiabilityProfileRatioRequest::class);

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

        $result = $this->traitStrongLiabilityProfileRatioStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitStrongLiabilityProfileRatioUpdate();

        return $result;
    }
}
