<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CurrentDealCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CurrentDealCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CurrentDealCategoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\CurrentDealCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/currentdeal_category');
        CRUD::setEntityNameStrings('Current Deal Category', 'Current Deal Categories');

        $list_current_deal_category = backpack_user()->hasPermissionTo('list_current_deal_category');

        $checker_current_deal_category = backpack_user()->hasPermissionTo('checker_current_deal_category');

            if($checker_current_deal_category)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_current_deal_category', 'revise', 'delete']);
                }
                else
                {
                    if($checker_current_deal_category)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_current_deal_category']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_current_deal_category', 'revise', 'delete']);
            }

            $this->crud->addButtonFromView('line', 'checker_current_deal_category', 'checker_current_deal_category', 'end');
        
        if($list_current_deal_category)
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
                                    'name' => 'category_code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'category_name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'check',
                                ]);

            
                                
            $this->crud->addField([
                                    'name' => 'category_code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
            $this->crud->addField([
                                    'name' => 'category_name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'description',
                                    'label' => 'Description',
                                    'type' => 'ckeditor',
                                    'tab' => 'General'
                                ]);

            
            $this->crud->addField([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'select2_from_array',
                                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject'),
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                    'label'     => 'Lender',
                    'type'      => 'relationship',
                    'name'      => 'lenders',
                    'entity'    => 'lenders', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Lender'
                    ]);

            $this->crud->addField([
                    'label'     => 'Trustee',
                    'type'      => 'relationship',
                    'name'      => 'trustees',
                    'entity'    => 'trustees', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Trustee'
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
        CRUD::setValidation(CurrentDealCategoryRequest::class);

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
