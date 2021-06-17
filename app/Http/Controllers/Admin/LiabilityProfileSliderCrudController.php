<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LiabilityProfileSliderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LiabityProfileSliderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LiabilityProfileSliderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\LiabilityProfileSlider::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/liabilityprofileslider');
        CRUD::setEntityNameStrings('liability profile slider', 'liability profile sliders');

        $checker_liability_profile_slider = backpack_user()->hasPermissionTo('checker_liability_profile_slider');

            if($checker_liability_profile_slider)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_liability_profile_slider', 'revise', 'delete']);
                }
                else
                {
                    if($checker_liability_profile_slider)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_liability_profile_slider']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_liability_profile_slider', 'revise', 'delete']);
            }

            $this->crud->addButtonFromView('line', 'checker_liability_profile_slider', 'checker_liability_profile_slider', 'end');
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

        CRUD::addColumn('slider_code');
        CRUD::addColumn('name');
        CRUD::addColumn([
            'name' => 'image',
            'type' => 'image'
        ]);
        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'select',
            'name' => 'liability_profile_category_id',
            'entity' => 'profileCat',
            'attribute' => 'name',
        ]);

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
        CRUD::setValidation(LiabilityProfileSliderRequest::class);

        //CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'slider_code',
            'label' => 'Slider code',
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Slider name',
        ]);
        CRUD::addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'browse',
        ]);
        CRUD::addField([
            'label' => 'Category',
            'type' => 'select',
            'name' => 'liability_profile_category_id',
            'entity' => 'profileCat',
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

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $clonedEntry = $this->crud->model->findOrFail($id)->replicate();

        $lastData = \DB::table('liability_profile_slider')->orderBy('id', 'DESC')->first();
        $last_id = $lastData->id;
        $last_id = $last_id+1;

        $clonedEntry->slider_code = "SLIDER".$last_id;
        
        return (string) $clonedEntry->push();

        // if you still want to call the old clone method
        //$this->traitClone($id);
    }
}
