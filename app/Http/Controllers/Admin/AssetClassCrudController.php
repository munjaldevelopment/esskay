<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AssetClassRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AssetClassCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AssetClassCrudController extends CrudController
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
        CRUD::setModel(\App\Models\AssetClass::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/asset_class');
        CRUD::setEntityNameStrings('Asset Class', 'Asset Classes');
		
		$list_asset_class = backpack_user()->hasPermissionTo('list_asset_class');
		
		if($list_asset_class)
		{
			$this->crud->allowAccess('show');
			$this->crud->enableExportButtons();
			
			$this->crud->denyAccess(['delete']);
			
			$this->crud->addColumn([
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
								]);
								
			$this->crud->addField([
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
								]);
								
			//$this->crud->enableAjaxTable();

			$this->crud->addFilter([
				  'type' => 'text',
				  'name' => 'name',
				  'label'=> 'Name'
				],
				false,
				function($value) {
					$this->crud->addClause('where', 'name', 'LIKE', "%$value%");
			});
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
        CRUD::setValidation(AssetClassRequest::class);

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
