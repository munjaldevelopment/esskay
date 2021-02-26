<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserPDFRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserPDFCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserPDFCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserPDF::class);
		CRUD::setRoute(config('backpack.base.route_prefix') . '/user_pdf');
        CRUD::setEntityNameStrings('user pdf', 'user pdfs');
		
		$this->crud->allowAccess('show');
		$this->crud->enableExportButtons();
		
		$this->crud->denyAccess(['create', 'update', 'delete']);
		
		$this->crud->addColumn([
                'label'     => 'Article',
                'type'      => 'select',
                'name'      => 'article_id',
                'entity'    => 'article', //function name
                'attribute' => 'title', //name of fields in models table like districts
                'model'     => "App\Models\Article", //name of Models

                ]);
				
		$this->crud->addColumn([
                'label'     => 'User',
                'type'      => 'select',
                'name'      => 'user_id',
                'entity'    => 'users', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\User", //name of Models

                ]);
				
		$this->crud->addColumn([
                                'name' => 'download_date',
                                'label' => 'Download Date',
                                'type' => 'datetime'
                            ]);
				
		$this->crud->addField([
                'label'     => 'Document',
                'type'      => 'select2',
                'name'      => 'article_id',
                'entity'    => 'article', //function name
                'attribute' => 'title', //name of fields in models table like districts
                'model'     => "App\Models\Document", //name of Models

                ]);
				
		$this->crud->addField([
                'label'     => 'User',
                'type'      => 'select2',
                'name'      => 'user_id',
                'entity'    => 'users', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\User", //name of Models

                ]);
			
		$this->crud->addField([
                                'name' => 'download_date',
                                'label' => 'Download Date',
                                'type' => 'datetime'
                            ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(UserPDFRequest::class);

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
