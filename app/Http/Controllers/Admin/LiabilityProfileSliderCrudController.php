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
        CRUD::addColumn('image');
        CRUD::addColumn('profileCategory');

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
            'label' => 'Category',
            'type' => 'select',
            'name' => 'liability_profile_category_id',
            'entity' => 'profileCategory',
            'attribute' => 'name',
        ]);
        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
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
