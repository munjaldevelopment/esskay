<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LenderBankingDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LenderBankingDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LenderBankingDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitLenderBankingDetailStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitLenderBankingDetailUpdate; } 
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
        CRUD::setModel(\App\Models\LenderBankingDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lender_banking_detail');
        CRUD::setEntityNameStrings('Lender Banking Detail', 'Lender Banking Details');
		$list_lender_banking = backpack_user()->hasPermissionTo('list_lender_banking');
		
		if($list_lender_banking)
		{
			$adminRolesRow  = \DB::table('model_has_roles')->where('role_id', '=', '1')->get();
			
			$adminRolesData = array();
			foreach($adminRolesRow as $row)
			{
				$adminRolesData[] = $row->model_id;
			}
			
			$lenderRolesRow  = \DB::table('lenders')->whereIn('user_id', $adminRolesData)->get();
			
			$lenderRolesData = array();
			foreach($lenderRolesRow as $row)
			{
				$lenderRolesData[] = $row->id;
			}
			
			//dd($lenderRolesData);
			
			$this->crud->addClause('whereNotIn', 'lender_id', $lenderRolesData);
			
			$this->crud->orderBy('updated_at', 'DESC');
			
			
			$this->crud->allowAccess('show');
			$this->crud->enableExportButtons();
			
			$maker_banking_arrangment = backpack_user()->hasPermissionTo('maker_banking_arrangment');
			if($maker_banking_arrangment)
			{
				$this->crud->allowAccess(['create', 'update']);
			}
			else
			{
				$this->crud->denyAccess(['create', 'update']);
			}
			
			$checker_banking_arrangment = backpack_user()->hasPermissionTo('checker_banking_arrangment');
			if($checker_banking_arrangment)
			{
				$this->crud->allowAccess(['checker_banking_arrangment', 'revise']);
			}
			else
			{
				$this->crud->denyAccess(['checker_banking_arrangment', 'revise']);
			}
			
			if($checker_banking_arrangment && !$maker_banking_arrangment)
			{
				$this->crud->addClause('where', 'lender_banking_status', '=', "0");
			}
			
			$this->crud->addColumn([
					'label'     => 'Lender',
					'type'      => 'select',
					'name'      => 'lender_id',
					'entity'    => 'lenders', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\Lender", //name of Models

					]);

            $this->crud->addColumn([
                    'label'     => 'Lender Banking',
                    'type'      => 'select',
                    'name'      => 'lender_banking_id',
                    'entity'    => 'lenderBanking', //function name
                    'attribute' => 'lender_banking_code', //name of fields in models table like districts
                    'model'     => "App\Models\LenderBanking", //name of Models

                    ]);
					
			$this->crud->addColumn([
					'label'     => 'Banking Arrangment',
					'type'      => 'select',
					'name'      => 'banking_arrangment_id',
					'entity'    => 'bankingArrangment', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\BankingArrangment", //name of Models

					]);
					
			$this->crud->addColumn([
					'label'     => 'Sanction Amount',
					'type'      => 'text',
					'name'      => 'sanction_amount',
					]);
					
			$this->crud->addColumn([
					'label'     => 'Outstanding Amount',
					'type'      => 'text',
					'name'      => 'outstanding_amount',
					]);
					
			$this->crud->addField([
					'label'     => 'Lender',
					'type'      => 'select2',
					'name'      => 'lender_id',
					'entity'    => 'lenders', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\Lender", //name of Models

					]);

            $this->crud->addField([
                    'label'     => 'Lender Banking',
                    'type'      => 'select2',
                    'name'      => 'lender_banking_id',
                    'entity'    => 'lenderBanking', //function name
                    'attribute' => 'lender_banking_code', //name of fields in models table like districts
                    'model'     => "App\Models\LenderBanking", //name of Models

                    ]);
					
			$this->crud->addField([
					'label'     => 'Banking Arrangment',
					'type'      => 'select2',
					'name'      => 'banking_arrangment_id',
					'entity'    => 'bankingArrangment', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\BankingArrangment", //name of Models

					]);
					
			$this->crud->addField([
					'label'     => 'Sanction Amount',
					'type'      => 'number',
					'name'      => 'sanction_amount',
					]);
					
			$this->crud->addField([
					'label'     => 'Outstanding Amount',
					'type'      => 'number',
					'name'      => 'outstanding_amount',
					]);

			$this->crud->addField([
					'name' => 'lender_banking_status',
					'label' => 'Banking Status',
					'type' => 'select2_from_array',
					'options' => ['0' => 'Inactive']
					
				]);
					
			$this->crud->addButtonFromView('line', 'checker_banking_arrangment', 'checker_banking_arrangment', 'end');
			
			$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportLenderBankingDetailButton', 'end');
			$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importLenderBankingDetailButton', 'end');
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
        CRUD::setValidation(LenderBankingDetailRequest::class);

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
	
	public function checkerBankingArrangment($lender_banking_id)
	{
		$updateData = array('lender_banking_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('lender_banking')->where(['id' => $lender_banking_id])->update($updateData);

		\DB::table('lender_banking_revisions')->where(['lender_banking_id' => $lender_banking_id])->update($updateData);
	}

	public function store()
    {
      	$this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitLenderBankingStore();

        $lender_banking_id =  $this->crud->entry->id;
        $lender_id = $this->crud->getRequest()->lender_id;
        $banking_arrangment_id = $this->crud->getRequest()->banking_arrangment_id;
        $sanction_amount = $this->crud->getRequest()->sanction_amount;
        $outstanding_amount = $this->crud->getRequest()->outstanding_amount;
        $lender_banking_status = $this->crud->getRequest()->lender_banking_status;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $document_status = $this->crud->getRequest()->document_status;


        \DB::table('lender_banking_revisions')->insert(['lender_banking_id' => $lender_banking_id, 'lender_id' => $lender_id, 'banking_arrangment_id' => $banking_arrangment_id,'sanction_amount' => $sanction_amount, 'outstanding_amount' => $outstanding_amount, 'lender_banking_status' => $lender_banking_status]);

        return $result;
    }    

    public function update()
    {
      	$this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitLenderBankingUpdate();

        $lender_banking_id =  $this->crud->getRequest()->id;
        $lender_id = $this->crud->getRequest()->lender_id;
        $banking_arrangment_id = $this->crud->getRequest()->banking_arrangment_id;
        $sanction_amount = $this->crud->getRequest()->sanction_amount;
        $outstanding_amount = $this->crud->getRequest()->outstanding_amount;
        $lender_banking_status = $this->crud->getRequest()->lender_banking_status;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $document_status = $this->crud->getRequest()->document_status;


        \DB::table('lender_banking_revisions')->insert(['lender_banking_id' => $lender_banking_id, 'lender_id' => $lender_id, 'banking_arrangment_id' => $banking_arrangment_id,'sanction_amount' => $sanction_amount, 'outstanding_amount' => $outstanding_amount, 'lender_banking_status' => $lender_banking_status]);
    
        return $result;
    }
}
