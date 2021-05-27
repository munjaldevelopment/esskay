<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LiabilityProfileCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LiabityProfileCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LiabilityProfileCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\LiabilityProfileCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/liabilityprofilecategory');
        CRUD::setEntityNameStrings('liability profile category', 'liability profile categories');

        $checker_liability_profile_category = backpack_user()->hasPermissionTo('checker_liability_profile_category');

            if($checker_liability_profile_category)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_liability_profile_category', 'revise', 'delete']);
                }
                else
                {
                    if($checker_liability_profile_category)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_liability_profile_category']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_liability_profile_category', 'revise', 'delete']);
            }

            $this->crud->addButtonFromView('line', 'checker_liability_profile_category', 'checker_liability_profile_category', 'end');
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

        CRUD::addColumn('category_code');
        CRUD::addColumn('name');
        CRUD::addColumn('parent');

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
        CRUD::setValidation(LiabilityProfileCategoryRequest::class);

        //CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'category_code',
            'label' => 'category code',
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'category name',
        ]);
        CRUD::addField([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
        ]);
        
        $this->crud->addField([
            'label'     => 'Status',
            'type'      => 'select2_from_array',
            'name'      => 'status',
            'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
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

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'name');
        CRUD::set('reorder.max_level', 2);
    }
}
