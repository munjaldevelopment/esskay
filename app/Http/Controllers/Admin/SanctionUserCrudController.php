<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use App\Models\SanctionUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SanctionUserRequest;
use App\Http\Requests\SanctionUserUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SanctionUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SanctionUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitSanctionUserStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitSanctionUserUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
	
	use \Backpack\ReviseOperation\ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SanctionUser::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sanction_user');
        CRUD::setEntityNameStrings('Sanction User', 'Sanction Users');
		
        $list_sanction_users = backpack_user()->hasPermissionTo('list_sanction_users');

        if($list_sanction_users)
        {
    		$this->crud->allowAccess(['delete', 'show']);
    		$this->crud->enableExportButtons();
    		
    		//$this->crud->denyAccess([]);
    		
    		$this->crud->addColumn([
                    'label'     => 'User',
                    'type'      => 'select',
                    'name'      => 'user_id',
                    'entity'    => 'users', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models

                    ]);
    		
    		$this->crud->addColumn([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
    					
    		// fields
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
	protected function addSanctionUserFields()
    {
		$this->crud->addField([
                'label'     => 'User',
                'type'      => 'select',
                'name'      => 'user_id',
                'entity'    => 'users', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\User", //name of Models
				'wrapperAttributes' => [
					'style' => 'display:none;'
				],
				'tab' => 'User'
                ]);
				
		$this->crud->addField([
                                'name' => 'name',
                                'label' => 'Name',
                                'type' => 'text',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'email',
                                'label' => 'Email',
                                'type' => 'text',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'phone',
                                'label' => 'Phone',
                                'type' => 'tel',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
								'tab' => 'User'
                            ]);
		
		$this->crud->addField([
                                'name' => 'is_onboard',
                                'label' => 'User On-board',
                                'type' => 'select2_from_array',
								'options' => ['Approve' => 'Approve', 'Pending' => 'Pending', 'Onboarded' => 'Onboarded'],
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'is_contact_us',
                                'label' => 'Show Contact Us',
                                'type' => 'select2_from_array',
								'options' => ['0' => 'No', '1' => 'Yes'],
								'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_sanction_letter',
                                'label' => 'Show Sanction Letter',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
	}
	
	protected function updateSanctionUserFields()
    {
		$this->crud->addField([
                'label'     => 'User',
                'type'      => 'select',
                'name'      => 'user_id',
                'entity'    => 'users', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\User", //name of Models
				'wrapperAttributes' => [
					'style' => 'display:none;'
				],
				'tab' => 'User'
                ]);
				
		$this->crud->addField([
                                'name' => 'name',
                                'label' => 'Name',
                                'type' => 'text',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'email',
                                'label' => 'Email',
                                'type' => 'text',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'phone',
                                'label' => 'Phone',
                                'type' => 'tel',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
								'tab' => 'User'
                            ]);
		
		$this->crud->addField([
                                'name' => 'is_onboard',
                                'label' => 'User On-board',
                                'type' => 'select2_from_array',
								'options' => ['Yet to onboarded' => 'Yet to onboarded', 'Onboarded' => 'Onboarded'],
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'is_contact_us',
                                'label' => 'Show Contact Us',
                                'type' => 'select2_from_array',
								'options' => ['0' => 'No', '1' => 'Yes'],
								'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_sanction_letter',
                                'label' => 'Show Sanction Letter',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
	}
	
    protected function setupCreateOperation()
    {
		$this->addSanctionUserFields();
        CRUD::setValidation(SanctionUserRequest::class);

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
		$this->updateSanctionUserFields();
        CRUD::setValidation(SanctionUserUpdateRequest::class);

        CRUD::setFromDb(); // fields
    }
	
	public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
		
		$result = $this->traitSanctionUserStore();
		
		// Save Data in user table
		$id = $this->crud->entry->id;

		
		$user_id = User::insertGetId([
			'name' => $this->crud->getRequest()->name,
			'email' => $this->crud->getRequest()->email,
			'phone' => $this->crud->getRequest()->phone,
			'user_otp' => '987654',
			'password' => Hash::make($this->crud->getRequest()->password),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		
		SanctionUser::where('id', $id)->update(['user_id' => $user_id]);
		
		// create role entry-
		\DB::table('model_has_roles')->insert(['role_id' => '22', 'model_type' => 'App\User', 'model_id' => $user_id]);
		
		
		return $result;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $user_logged_id = \Auth::user()->id;
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $user_id = $this->crud->getRequest()->user_id;

		//echo $user_id.",".$this->crud->getRequest()->password; exit;
        //dd($this->crud->getRequest()->all());
		
		if($this->crud->getRequest()->password == NULL)
		{
			User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'updated_at' => date('Y-m-d H:i:s')]);
		}
		else
		{
			User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'password' => Hash::make($this->crud->getRequest()->password), 'updated_at' => date('Y-m-d H:i:s')]);
		}
		
		$result = $this->traitSanctionUserUpdate();
		
		return $result;
    }

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'name');
        CRUD::set('reorder.max_level', 2);
    }
	
	protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.

        // Encrypt password if specified.
        if ($this->crud->getRequest()->input('password')) {
            $this->crud->getRequest()->request->set('password', Hash::make($this->crud->getRequest()->input('password')));
        } else {
            $this->crud->getRequest()->request->remove('password');
        }

        return $this->crud->getRequest();
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        return $this->crud->delete($id);
    }
}