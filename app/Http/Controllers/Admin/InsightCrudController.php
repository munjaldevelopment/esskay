<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InsightRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InsightCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InsightCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Insight::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/insight');
        CRUD::setEntityNameStrings('insight', 'insights');

        $list_insight = backpack_user()->hasPermissionTo('list_insight');
        
        if($list_insight)
        {
            $this->crud->allowAccess('show');
            $this->crud->allowAccess('reorder');
            $this->crud->enableExportButtons();
            
            
            $this->crud->set('reorder.label', 'name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 3);
            $this->crud->orderBy('lft', 'ASC');
            
            //$this->crud->enableReorder('name', 2);
            
            //$this->crud->denyAccess(['delete']);
            
            $this->crud->addColumn([
                                    'name' => 'insight_category_id',
                                    'label' => 'Category',
                                    'type' => 'select',
                                    'entity'    => 'insightCategory', //function name
                                    'attribute' => 'category_code', //name of fields in models table like districts
                                    'model'     => "App\Models\InsightCategory", //name of Models
                                ]);
            $this->crud->addColumn([
                                    'name' => 'insight_code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'value1',
                                    'label' => 'Value1',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'check',
                                ]);

            
            $this->crud->addField([
                                    'name' => 'insight_category_id',
                                    'label' => 'Category',
                                    'type' => 'select2',
                                    'entity'    => 'insightCategory', //function name
                                    'attribute' => 'category_code', //name of fields in models table like districts
                                    'model'     => "App\Models\InsightCategory", //name of Models
                                    'tab' => 'General'
                                ]);               
            $this->crud->addField([
                                    'name' => 'insight_code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'value1',
                                    'label' => 'Value1',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'value2',
                                    'label' => 'Value2',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'value3',
                                    'label' => 'Value3',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'value4',
                                    'label' => 'Value4',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'value5',
                                    'label' => 'Value5',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'value6',
                                    'label' => 'Value6',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'checkbox',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                    'label'     => 'Lender',
                    'type'      => 'relationship ',
                    'name'      => 'lenders',
                    'entity'    => 'lenders', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Lender'
                    ]);
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
        CRUD::setValidation(InsightRequest::class);

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
}
