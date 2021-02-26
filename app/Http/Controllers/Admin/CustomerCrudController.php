<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');

        $this->crud->enableExportButtons();
        
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
        $this->crud->addColumn([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'text',
            'hint' => '',
        ]);

         $this->crud->addColumn([
            'name' => 'last_name',
            'label' => 'Last Name',
            'type' => 'text',
            'hint' => '',                                                                           
        ]);

        $this->crud->addColumn([
            'name' => 'telephone',
            'label' => 'Mobile',
            'type' => 'text',
            'hint' => '',                                                                           
        ]);

        $this->crud->addColumn([
            'name' => 'city',
            'label' => 'City',
            'type' => 'text',
            'hint' => '',                                                                           
        ]);

        $this->crud->addColumn([
            'name' => 'state',
            'label' => 'State',
            'type' => 'text',
            'hint' => '',                                                                           
        ]); 

        $this->crud->addFilter([ // select2 filter
                'name' => 'first_name',
                'type' => 'text',
                'label'=> 'Name',
            ], function () {
                false;
            }, function ($value) { // if the filter is active
                $this->crud->addClause('where', 'first_name', 'LIKE %'.$value.'%');
            });

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);

        //CRUD::setFromDb(); // fields
        /*$this->crud->addField([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'select2_from_array',
            'options' => ['--Select--', 'A' => 'A', 'B' => 'B'],
            'hint' => '',
        ]);*/

        $this->crud->addField([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'text',
            'hint' => '',
        ]);

        $this->crud->addField([
            'name' => 'last_name',
            'label' => 'Last Name',
            'type' => 'text',
            'hint' => '',
        ]);

        $this->crud->addField([
            'name' => 'email',
            'label' => 'Email Address',
            'type' => 'email',
            'hint' => '',
        ]);

        $this->crud->addField([
            'name' => 'telephone',
            'label' => 'Mobile',
            'type' => 'text',
            'hint' => '',
        ]);

        $this->crud->addField([
            'name' => 'address1',
            'label' => 'Address',
            'type' => 'text',
            'hint' => '',
        ]);

        $this->crud->addField([
            'name' => 'address2',
            'label' => 'Land mark',
            'type' => 'text',
            'hint' => '',
        ]);

         $this->crud->addField([
            'name' => 'city',
            'label' => 'City',
            'type' => 'text',
            'hint' => '',
        ]);

         $this->crud->addField([
            'name' => 'state',
            'label' => 'State',
            'type' => 'select2_from_array',
            'options' => ['' => '--Select--', '1' => 'Rajasthan', '2' => 'Uttar Pradesh'],
            'hint' => '',
        ]);

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
}
