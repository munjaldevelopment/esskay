<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserLoginAttemptAttemptRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserLoginAttemptCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserLoginAttemptCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserLoginAttempt::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user_login_attempt');
        CRUD::setEntityNameStrings('User Login Attempt', 'User Logins Attempt');
		
		$this->crud->allowAccess('show');
		$this->crud->denyAccess(['create', 'update', 'delete']);
		$this->crud->enableExportButtons();
		
		$this->crud->addColumn([
                'label'     => 'Email',
                'type'      => 'text',
                'name'      => 'email',
                ]);
				
		$this->crud->addColumn([
                'label'     => 'User IP',
                'type'      => 'text',
                'name'      => 'user_ip',
                ]);
				
		$this->crud->addColumn([
                'label'     => 'User Browser',
                'type'      => 'text',
                'name'      => 'user_browser',
                ]);
				
		$this->crud->addColumn([
                'label'     => 'Device Type',
                'type'      => 'text',
                'name'      => 'device_type',
                ]);
				
		$this->crud->addColumn([
                'label'     => 'Login Type',
                'type'      => 'text',
                'name'      => 'login_type',
                ]);
				
		$this->crud->addColumn([
                'label'     => 'Time',
                'type'      => 'datetime',
                'name'      => 'created_at',
                ]);
			
		// Field
		$this->crud->addField([
                'label'     => 'Email',
                'type'      => 'text',
                'name'      => 'email',
                ]);
				
		$this->crud->addField([
                'label'     => 'User IP',
                'type'      => 'text',
                'name'      => 'user_ip',
                ]);
				
		$this->crud->addField([
                'label'     => 'Login Type',
                'type'      => 'text',
                'name'      => 'login_type',
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
        CRUD::setValidation(UserLoginAttemptRequest::class);

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
