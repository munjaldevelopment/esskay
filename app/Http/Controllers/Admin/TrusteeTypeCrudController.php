<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrusteeTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrusteeTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TrusteeTypeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\TrusteeType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trustee_type');

        CRUD::setEntityNameStrings('Trustee Type', 'Trustee Types');
        
        $list_lender_type = backpack_user()->hasPermissionTo('list_trustee_type');
        
        if($list_lender_type)
        {
            $this->crud->allowAccess('show');
            $this->crud->allowAccess('reorder');
            $this->crud->enableExportButtons();
            
            $this->crud->set('reorder.label', 'name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 2);
            $this->crud->orderBy('lft', 'ASC');
            
            //$this->crud->enableReorder('category_name', 2);
            
            $this->crud->denyAccess(['delete']);
            
            $this->crud->addColumn([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
                                
            $this->crud->addColumn([
                                    'name' => 'parent_id',
                                    'type'      => 'select',
                                    'name'      => 'parent_id',
                                    'entity'    => 'trusteeType', //function name
                                    'attribute' => 'name', //name of fields in models table like districts
                                    'model'     => "App\Models\TrusteeType", //name of Models
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
        CRUD::setValidation(TrusteeTypeRequest::class);

        //CRUD::setFromDb(); // fields
        $this->crud->addField([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);

        $this->crud->addField([
                                    'name' => 'parent_id',
                                    'type'      => 'select2',
                                    'name'      => 'parent_id',
                                    'entity'    => 'trusteeType', //function name
                                    'attribute' => 'name', //name of fields in models table like districts
                                    'model'     => "App\Models\TrusteeType", //name of Models
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
