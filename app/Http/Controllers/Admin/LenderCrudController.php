<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use App\Models\Lender;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LenderRequest;
use App\Http\Requests\LenderUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LenderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LenderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitLenderStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitLenderUpdate; }
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
        CRUD::setModel(\App\Models\Lender::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lender');
        CRUD::setEntityNameStrings('Lender', 'Lenders');
		
        $list_lender = backpack_user()->hasPermissionTo('list_lender');

        if($list_lender)
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
    							
    		$this->crud->addColumn([
                                    'name' => 'code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                ]);
    							
    		$this->crud->addColumn([
                                    'name' => 'lot_name',
                                    'label' => 'Lot Name',
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
	protected function addLenderFields()
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
                                'name' => 'code',
                                'label' => 'Code',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'slug',
                                'label' => 'Slug',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'lot_name',
                                'label' => 'Lot Name',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		/*$this->crud->addField([
                                'name' => 'availment_date',
                                'label' => 'Availment Date',
                                'type' => 'date',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'sanction_date',
                                'label' => 'Sanction Date',
                                'type' => 'date',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'sanction_amount',
                                'label' => 'Sanction Amount',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'principal_assigned',
                                'label' => 'Principal Assigned',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'outstanding',
                                'label' => 'Outstanding',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'interest_rate',
                                'label' => 'Int. Rate',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$this->crud->addField([
                                'name' => 'inclusive_irr',
                                'label' => 'Inc. IRR',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$this->crud->addField([
                                'name' => 'processing_fee',
                                'label' => 'Processing Fee',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$freq = array('' => '-Select-', 'Monthly' => 'Monthly', 'Quarterly' => 'Quarterly', 'Half Yearly' => 'Half Yearly', 'Yearly' => 'Yearly');
		
		$this->crud->addField([
                                'name' => 'principal_repayment_frequency',
                                'label' => 'Principal Repayment Freq.',
                                'type' => 'select2_from_array',
								'options' => $freq,
								'tab' => 'Freqquence'
                            ]);
					
		$this->crud->addField([
                                'name' => 'interest_payment_frequency',
                                'label' => 'Interest Payment Freq.',
                                'type' => 'select2_from_array',
								'options' => $freq,
								'tab' => 'Freqquence'
                            ]);
							
		$this->crud->addField([
                                'name' => 'door_to_door',
                                'label' => 'Door to Door',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'maturity_date',
                                'label' => 'Maturity Date',
                                'type' => 'date',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'security_margin_receivables',
                                'label' => 'Security Margin on receivables',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'security_required',
                                'label' => 'Security required',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'fixed_deposit_required',
                                'label' => 'Fixed Deposit Required',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'personal_guarantee',
                                'label' => 'Personal Guarantee',
                                'type' => 'text',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                'label'     => 'Lender Type',
                'type'      => 'select2',
                'name'      => 'lender_type_id',
                'entity'    => 'lenderType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\LenderType", //name of Models
				'tab' => 'Type'

                ]);
				
		$this->crud->addField([
                'label'     => 'Instrument Type',
                'type'      => 'select2',
                'name'      => 'instrument_type_id',
                'entity'    => 'instrumentType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\InstrumentType", //name of Models
				'tab' => 'Type'

                ]);
				
		$this->crud->addField([
                'label'     => 'Facility Type',
                'type'      => 'select2',
                'name'      => 'facility_type_id',
                'entity'    => 'facilityType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\FacilityType", //name of Models
				'tab' => 'Type'

                ]);*/
		
		$this->crud->addField([
                                'name' => 'is_onboard',
                                'label' => 'User On-board',
                                'type' => 'select2_from_array',
								'options' => ['Approve' => 'Approve', 'Pending' => 'Pending', 'Onboarded' => 'Onboarded'],
								'tab' => 'User'
                            ]);
							
					
		$this->crud->addField([
                                'name' => 'lender_banking',
                                'label' => 'Banking Arrangment',
                                'type' => 'banking_arrangment',
								//'allows_multiple' => 'true',
								'tab' 	=> 'Banking Arrangment Info',
                            ]);
							
		
		// Roles
		$this->crud->addField([
                                'name' => 'is_banking_arrangement',
                                'label' => 'Show Banking Arrangment',
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
	
	protected function updateLenderFields()
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
                                'name' => 'code',
                                'label' => 'Code',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'slug',
                                'label' => 'Slug',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		$this->crud->addField([
                                'name' => 'lot_name',
                                'label' => 'Lot Name',
                                'type' => 'hidden',
								'tab' => 'User'
                            ]);
							
		/*$this->crud->addField([
                                'name' => 'availment_date',
                                'label' => 'Availment Date',
                                'type' => 'date',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'sanction_date',
                                'label' => 'Sanction Date',
                                'type' => 'date',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'sanction_amount',
                                'label' => 'Sanction Amount',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'principal_assigned',
                                'label' => 'Principal Assigned',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'outstanding',
                                'label' => 'Outstanding',
                                'type' => 'number',
								'tab' => 'Avail'
                            ]);
							
		$this->crud->addField([
                                'name' => 'interest_rate',
                                'label' => 'Int. Rate',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$this->crud->addField([
                                'name' => 'inclusive_irr',
                                'label' => 'Inc. IRR',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$this->crud->addField([
                                'name' => 'processing_fee',
                                'label' => 'Processing Fee',
                                'type' => 'number',
								'tab' => 'Interest'
                            ]);
							
		$freq = array('' => '-Select-', 'Monthly' => 'Monthly', 'Quarterly' => 'Quarterly', 'Half Yearly' => 'Half Yearly', 'Yearly' => 'Yearly');
		
		$this->crud->addField([
                                'name' => 'principal_repayment_frequency',
                                'label' => 'Principal Repayment Freq.',
                                'type' => 'select2_from_array',
								'options' => $freq,
								'tab' => 'Freqquence'
                            ]);
					
		$this->crud->addField([
                                'name' => 'interest_payment_frequency',
                                'label' => 'Interest Payment Freq.',
                                'type' => 'select2_from_array',
								'options' => $freq,
								'tab' => 'Freqquence'
                            ]);
							
		$this->crud->addField([
                                'name' => 'door_to_door',
                                'label' => 'Door to Door',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'maturity_date',
                                'label' => 'Maturity Date',
                                'type' => 'date',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'security_margin_receivables',
                                'label' => 'Security Margin on receivables',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'security_required',
                                'label' => 'Security required',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'fixed_deposit_required',
                                'label' => 'Fixed Deposit Required',
                                'type' => 'number',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                                'name' => 'personal_guarantee',
                                'label' => 'Personal Guarantee',
                                'type' => 'text',
								'tab' => 'Other'
                            ]);
							
		$this->crud->addField([
                'label'     => 'Lender Type',
                'type'      => 'select2',
                'name'      => 'lender_type_id',
                'entity'    => 'lenderType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\LenderType", //name of Models
				'tab' => 'Type'

                ]);
				
		$this->crud->addField([
                'label'     => 'Instrument Type',
                'type'      => 'select2',
                'name'      => 'instrument_type_id',
                'entity'    => 'instrumentType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\InstrumentType", //name of Models
				'tab' => 'Type'

                ]);
				
		$this->crud->addField([
                'label'     => 'Facility Type',
                'type'      => 'select2',
                'name'      => 'facility_type_id',
                'entity'    => 'facilityType', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'model'     => "App\Models\FacilityType", //name of Models
				'tab' => 'Type'

                ]);*/
		
		$this->crud->addField([
                                'name' => 'is_onboard',
                                'label' => 'User On-board',
                                'type' => 'select2_from_array',
								'options' => ['Yet to onboarded' => 'Yet to onboarded', 'Onboarded' => 'Onboarded'],
								'tab' => 'User'
                            ]);
							
							
		$this->crud->addField([
                                'name' => 'lender_banking',
                                'label' => 'Banking Arrangment',
                                'type' => 'banking_arrangment_edit',
								'allows_multiple' => 'true',
								'tab' 	=> 'Banking Arrangment Info',
                            ]);
							
							
		// Roles
		$this->crud->addField([
                                'name' => 'is_banking_arrangement',
                                'label' => 'Show Banking Arrangment',
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
		$this->addLenderFields();
        CRUD::setValidation(LenderRequest::class);

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
		$this->updateLenderFields();
        CRUD::setValidation(LenderUpdateRequest::class);

        CRUD::setFromDb(); // fields
    }
	
	public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
		
		$result = $this->traitLenderStore();
		
		// Save Data in user table
		$id = $this->crud->entry->id;

		
		$user_id = User::insertGetId([
			'name' => $this->crud->entry->name,
			'email' => $this->crud->entry->email,
			'phone' => $this->crud->entry->phone,
			'user_otp' => '987654',
			'password' => Hash::make($this->crud->entry->password),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		
		Lender::where('id', $id)->update(['user_id' => $user_id]);
		
		// create role entry-
		\DB::table('model_has_roles')->insert(['role_id' => '4', 'model_type' => 'App\User', 'model_id' => $user_id]);
		
		if($this->crud->getRequest()->lender_banking_sanction)
		{
			foreach($this->crud->getRequest()->lender_banking_sanction as $k => $sanction_amount)
			{
				if(!is_null($sanction_amount))
				{
					\DB::table('lender_banking')->insert(['lender_id' => $id, 'banking_arrangment_id' => $this->crud->getRequest()->banking_arrangment_id[$k], 'sanction_amount' => $sanction_amount, 'outstanding_amount' => $this->crud->getRequest()->lender_banking_outstanding[$k], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
		
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
		
		if($this->crud->entry->password == "")
		{
			User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'updated_at' => date('Y-m-d H:i:s')]);
		}
		else
		{
			User::where('id', $user_id)->update(['name' => $this->crud->getRequest()->name, 'email' => $this->crud->getRequest()->email, 'phone' => $this->crud->getRequest()->phone, 'password' => Hash::make($this->crud->getRequest()->password), 'updated_at' => date('Y-m-d H:i:s')]);
		}
		
		if($this->crud->getRequest()->lender_banking_sanction)
		{
			\DB::table('lender_banking')->where('lender_id', $this->crud->getRequest()->id)->delete();
			
			foreach($this->crud->getRequest()->lender_banking_sanction as $k => $sanction_amount)
			{
				if(!is_null($sanction_amount))
				{
                    $lender_banking_status = 1;
                    if(($sanction_amount != $this->crud->getRequest()->lender_banking_sanction_old[$k]) || ($this->crud->getRequest()->lender_banking_outstanding[$k] != $this->crud->getRequest()->lender_banking_outstanding_old[$k]))
                    {
                        $lender_banking_status = 0;

                        // Insert into revision
                        if($sanction_amount != $this->crud->getRequest()->lender_banking_sanction_old[$k])
                        {
                            \DB::table('revisions')->insert(['revisionable_type' => 'App\Models\LenderBanking', 'revisionable_id' => $this->crud->getRequest()->id, 'user_id' => $user_logged_id, 'key' => 'lender_banking_sanction', 'old_value' => $this->crud->getRequest()->lender_banking_sanction_old[$k], 'new_value' => $sanction_amount, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                        }

                        if($this->crud->getRequest()->lender_banking_outstanding[$k] != $this->crud->getRequest()->lender_banking_outstanding_old[$k])
                        {
                            \DB::table('revisions')->insert(['revisionable_type' => 'App\Models\LenderBanking', 'revisionable_id' => $this->crud->getRequest()->id, 'user_id' => $user_logged_id, 'key' => 'lender_banking_outstanding', 'old_value' => $this->crud->getRequest()->lender_banking_outstanding_old[$k], 'new_value' => $this->crud->getRequest()->lender_banking_outstanding[$k], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                        }
                    }

					\DB::table('lender_banking')->insert(['lender_id' => $this->crud->getRequest()->id, 'banking_arrangment_id' => $this->crud->getRequest()->banking_arrangment_id[$k], 'sanction_amount' => $sanction_amount, 'outstanding_amount' => $this->crud->getRequest()->lender_banking_outstanding[$k], 'lender_banking_status' => $lender_banking_status, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

        $result = $this->traitLenderUpdate();
		
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
