<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Http\Requests\TransactionCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TransactionCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitDocumentCategoryStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitDocumentCategoryUpdate; }
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
        CRUD::setModel(\App\Models\TransactionCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction_category');
        CRUD::setEntityNameStrings('Transaction Category', 'Transaction Categories');

        $list_document_category = backpack_user()->hasPermissionTo('list_document_category');
        
        if($list_document_category)
        {
            $this->crud->allowAccess('show');
            $this->crud->allowAccess('reorder');
            $this->crud->enableExportButtons();
            
            $this->crud->set('reorder.label', 'category_name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 3);
            $this->crud->orderBy('lft', 'ASC');
            
            //$this->crud->enableReorder('category_name', 2);
            
            //$this->crud->denyAccess(['delete']);
            
            $this->crud->addColumn([
                                    'name' => 'category_name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'is_timeline',
                                    'label' => 'Timeline Show',
                                    'type' => 'check',
                                ]);
                                
            $this->crud->addColumn([
                                    'name' => 'category_icon',
                                    'label' => 'Icon',
                                    'type' => 'icon_picker',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'category_image',
                                    'label' => 'Image',
                                    'type' => 'image',
                                ]);

            
            
            $this->crud->addField([
                                    'name' => 'category_code',
                                    'label' => 'Category Code',
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
                                    'name' => 'is_timeline',
                                    'label' => 'Timeline Show',
                                    'type' => 'select2_from_array',
                                    'options' => ['0' => 'No', '1' => 'Yes'],
                                    'tab' => 'General'
                                ]);
                                
            $this->crud->addField([
                                    'name' => 'category_icon',
                                    'label' => 'Icon',
                                    'type'    => 'icon_picker',
                                    'iconset' => 'fontawesome', // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'category_image',
                                    'label' => 'Image',
                                    'type' => 'browse',
                                    'tab' => 'General'
                                ]);
                                
            $this->crud->addField([
                                    'name' => 'transaction_category_status',
                                    'label' => 'Status',
                                    'type' => 'select2_from_array',
                                    'options' => ['0' => 'Inactive', '1' => 'Active'],
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                    'label'     => 'Trustee',
                    'type'      => 'relationship ',
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
        CRUD::setValidation(TransactionCategoryRequest::class);

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
}
