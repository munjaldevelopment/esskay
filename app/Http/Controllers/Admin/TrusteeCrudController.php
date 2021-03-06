<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use App\Models\Trustee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TrusteeRequest;
use App\Http\Requests\TrusteeUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrusteeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TrusteeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitTrusteeStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitTrusteeUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
	
	use \Backpack\ReviseOperation\ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Trustee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trustee');
        CRUD::setEntityNameStrings('Trustee', 'Trustees');

        $list_trustee = backpack_user()->hasPermissionTo('list_trustee');

        if($list_trustee)
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
    protected function addTrusteeFields()
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
                            
        
        // Roles
        $this->crud->addField([
                                'name' => 'is_transaction',
                                'label' => 'Show Transaction',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_message_md',
                                'label' => 'Show Message from MD',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_insight',
                                'label' => 'Show Insight',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_current_deal',
                                'label' => 'Show Current Deal',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
        
                            
        $this->crud->addField([
                                'name' => 'is_document',
                                'label' => 'Show Document',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_financial_summary',
                                'label' => 'Show Financial Summary',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_newsletter',
                                'label' => 'Show Newsletter',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_contact_us',
                                'label' => 'Show Contact Us',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
    }
    
    protected function updateTrusteeFields()
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
                            
                            
                            
        // Roles
        // Roles
        $this->crud->addField([
                                'name' => 'is_transaction',
                                'label' => 'Show Transaction',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_message_md',
                                'label' => 'Show Message from MD',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_insight',
                                'label' => 'Show Insight',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);

        $this->crud->addField([
                                'name' => 'is_current_deal',
                                'label' => 'Show Current Deal',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
        
                            
        $this->crud->addField([
                                'name' => 'is_document',
                                'label' => 'Show Document',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_financial_summary',
                                'label' => 'Show Financial Summary',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_newsletter',
                                'label' => 'Show Newsletter',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
                            
        $this->crud->addField([
                                'name' => 'is_contact_us',
                                'label' => 'Show Contact Us',
                                'type' => 'select2_from_array',
                                'options' => ['0' => 'No', '1' => 'Yes'],
                                'tab' => 'Roles'
                            ]);
    }

    protected function setupCreateOperation()
    {
        $this->addTrusteeFields();
        CRUD::setValidation(TrusteeRequest::class);

        //CRUD::setFromDb(); // fields

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
        $this->updateTrusteeFields();
        CRUD::setValidation(TrusteeUpdateRequest::class);
    }

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitTrusteeStore();
        
        // Save Data in user table
        $id = $this->crud->entry->id;

        
        $user_id = User::insertGetId([
            'name' => $this->crud->getRequest()->name,
            'email' => $this->crud->getRequest()->email,
            'phone' => $this->crud->getRequest()->phone,
            'user_otp' => '987654',
            'password' => Hash::make($this->crud->getRequest()->password),
            'user_status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        
        Trustee::where('id', $id)->update(['user_id' => $user_id]);
        
        // create role entry-
        \DB::table('model_has_roles')->insert(['role_id' => '11', 'model_type' => 'App\User', 'model_id' => $user_id]);

        return $result;
    }

    public function update()
    {
        $user_logged_id = \Auth::user()->id;
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $user_id = $this->crud->getRequest()->user_id;

        if($this->crud->getRequest()->password == NULL)
        {
            User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'updated_at' => date('Y-m-d H:i:s')]);
        }
        else
        {
            User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'password' => Hash::make($this->crud->getRequest()->password), 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $result = $this->traitTrusteeUpdate();
        
        return $result;
    }
    
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $this->crud->getRequest()->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($this->crud->getRequest()->input('password')) {
            $this->crud->getRequest()->request->set('password', Hash::make($this->crud->getRequest()->input('password')));
        } else {
            $this->crud->getRequest()->request->remove('password');
        }

        return $this->crud->getRequest();
    }

}
