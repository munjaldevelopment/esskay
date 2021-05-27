<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CovidReliefLenderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CovidReliefLenderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CovidReliefLenderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitCovidReliefLenderStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitCovidReliefLenderUpdate; }
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
        CRUD::setModel(\App\Models\CovidReliefLender::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/covidrelief_lender');
        CRUD::setEntityNameStrings('Covid Relief Lender', 'Covid Relief Lenders');

        $list_covid_relief = backpack_user()->hasPermissionTo('list_covid_relief');
        if($list_covid_relief)
        {
            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();
            
            //$this->crud->denyAccess(['delete']);
            
            $maker_covid_relief = backpack_user()->hasPermissionTo('maker_covid_relief');
            if($maker_covid_relief)
            {
                //$this->crud->addClause('whereIn', 'status', [0,1]);
                $this->crud->allowAccess(['create', 'update']);
            }
            else
            {
                $this->crud->denyAccess(['create', 'update', 'delete']);
            }
            
            $checker_covid_relief = backpack_user()->hasPermissionTo('checker_covid_relief');
            if($checker_covid_relief)
            {
                //$this->crud->addClause('where', 'status', '=', "0");
                $this->crud->allowAccess(['checker_covid_relief', 'revise', 'delete']);
            }
            else
            {
                $this->crud->denyAccess(['checker_covid_relief', 'revise', 'delete']);
            }
            
            if($checker_covid_relief && !$maker_covid_relief)
            {
                $this->crud->addClause('where', 'status', '=', "0");
            }



            $this->crud->addButtonFromView('line', 'checker_covid_relief', 'checker_covid_relief', 'end');
            
            $this->crud->addColumn([
                                    'name' => 'bank_name',
                                    'label' => 'Bank Name',
                                    'type' => 'text',
                                ]);
                                
            $this->crud->addColumn([
                                    'name' => 'april_emi',
                                    'label' => 'April EMI',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'may_emi',
                                    'label' => 'May EMI',
                                    'type' => 'text',
                                ]);
                    
            $this->crud->addField([
                                    'name' => 'bank_name',
                                    'label' => 'Bank Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
                    
            $this->crud->addField([
                                    'name' => 'april_emi',
                                    'label' => 'April EMI',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'may_emi',
                                    'label' => 'May emi',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            
            $this->crud->addField([
                                    'name' => 'covid_relief_lender_status',
                                    'label' => 'Status',
                                    'type' => 'select2_from_array',
                                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject'),
                                    'tab' => 'Approve'
                                ]);
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
        CRUD::setValidation(CovidReliefLenderRequest::class);

        //CRUD::setFromDb(); // fields

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
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitCovidReliefLenderStore();

        $sms_status = config('general.sms_status');
                
        return $result;
    }

    public function update()
    {
        $user_logged_id = \Auth::user()->id;
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitCovidReliefLenderUpdate();

        $sms_status = config('general.sms_status');
                
        return $result;
    }
}
