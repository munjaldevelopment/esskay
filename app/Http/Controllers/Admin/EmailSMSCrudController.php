<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmailSMSRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmailSMSCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmailSMSCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EmailSMS::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/email_sms');
        CRUD::setEntityNameStrings('Email / SMS', 'Email / SMS');
		
		$list_email_sms = backpack_user()->hasPermissionTo('list_email_sms');
		
		if($list_email_sms)
		{
	
			$this->crud->allowAccess('show');
			$this->crud->enableExportButtons();
			
			$this->crud->denyAccess(['delete', 'update', 'create']);
			
			$this->crud->addColumn([
									'name' => 'send_type',
									'label' => 'Send Type',
									'type' => 'text',
								]);
								
			$this->crud->addColumn([
									'name' => 'send_to',
									'label' => 'Send TO',
									'type' => 'text',
								]);
								
			$this->crud->addColumn([
									'name' => 'send_subject',
									'label' => 'Subject',
									'type' => 'text',
								]);
								
			$this->crud->addColumn([
									'name' => 'is_deliver',
									'label' => 'Is Deliver',
									'type' => 'check',
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
        CRUD::setValidation(EmailSMSRequest::class);

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
