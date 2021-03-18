<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TransactionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\ReviseOperation\ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('transaction', 'transactions');

        $list_transaction = backpack_user()->hasPermissionTo('list_transaction');
        
        if($list_transaction)
        {
            $this->crud->allowAccess('show');
            $this->crud->allowAccess('reorder');
            $this->crud->enableExportButtons();

            $maker_transaction = backpack_user()->hasPermissionTo('maker_transaction');
            if($maker_transaction)
            {
                //$this->crud->addClause('whereIn', 'document_status', [0,1]);
                $this->crud->allowAccess(['create', 'update']);
            }
            else
            {
                $this->crud->denyAccess(['create', 'update', 'delete']);
            }
            
            $checker_transaction = backpack_user()->hasPermissionTo('checker_transaction');
            if($checker_transaction)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    //$this->crud->addClause('where', 'document_status', '=', "0");
                    $this->crud->allowAccess(['checker_transaction', 'revise', 'delete']);
                }
                else
                {
                    $this->crud->denyAccess(['revise']);
                    $this->crud->allowAccess(['checker_transaction']);
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_transaction', 'revise', 'delete']);
            }
            
            
            $this->crud->set('reorder.label', 'name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 3);
            $this->crud->orderBy('updated_at', 'ASC');
            
            //$this->crud->enableReorder('name', 2);
            
            //$this->crud->denyAccess(['delete']);
            $this->crud->addColumn([
                                    'name' => 'name',
                                    'label' => 'Trans Name',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                    'label'     => 'Created',
                    'type'      => 'select',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models

                    ]);
            $this->crud->addColumn([
                    'label'     => 'Trans. Type',
                    'type'      => 'select',
                    'name'      => 'transaction_category_id',
                    'entity'    => 'transactionCategory', //function name
                    'attribute' => 'category_name', //name of fields in models table like districts
                    'model'     => "App\Models\TransactionCategory", //name of Models

                    ]);

            $this->crud->addColumn([
                                    'name' => 'transaction_live_date',
                                    'label' => 'Live Date',
                                    'type' => 'text',
                                ]);

             $this->crud->addColumn([
                                    'name' => 'transaction_matured_date',
                                    'label' => 'Matured Date',
                                    'type' => 'text',
                                ]);



            $this->crud->addButtonFromView('line', 'checker_transaction', 'checker_transaction', 'end');
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
        $this->addTransactionFields();
        CRUD::setValidation(TransactionRequest::class);

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
        $this->updateTransactionFields();
        CRUD::setValidation(TransactionRequest::class);

        //CRUD::setFromDb(); // fields
    }

    protected function addTransactionFields()
    {
        $this->crud->addField([
                                'name' => 'name',
                                'label' => 'Name of Transaction',
                                'type' => 'text',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                'label'     => 'Type of Transaction',
                'type'      => 'select2',
                'name'      => 'transaction_category_id',
                'entity'    => 'transactionCategory', //function name
                'attribute' => 'category_name', //name of fields in models table like districts
                'model'     => "App\Models\TransactionCategory", //name of Models
                'tab' => 'General'
                ]);

        $is_admin = backpack_user()->hasRole('Super Admin');

        if($is_admin)
        {
            $userData = array();
            $users = \DB::table('users')->where('user_status', '1')->get();
            foreach ($users as $key => $roww) {
                $userData[$roww->id] = $roww->name;
            }

            $this->crud->addField([
                    'label'     => 'Created By',
                    'type'      => 'select2_from_array',
                    'name'      => 'user_id',
                    'options'   => $userData,
                    'tab'       => 'General',

            ]);
        }
        else
        {
            $this->crud->addField([
                    'label'     => 'Created By',
                    'type'      => 'hidden',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models
                    'value'     => backpack_user()->id, //name of Models
                    'tab'       => 'General'
            ]);
        }

        $transaction_code = "";
        $transData = \DB::table('transactions')->orderBy('id', 'DESC')->first();
        if($transData)
        {
            if($transData->id <= 9)
            {
                $transaction_code = "ESSKAYTRANS0000".($transData->id + 1);
            }
            else if($transData->id > 9 && $transData->id <= 99) 
            {
                $transaction_code = "ESSKAYTRANS000".($transData->id + 1);
            }
            else if($transData->id > 99 && $transData->id <= 999) 
            {
                $transaction_code = "ESSKAYTRANS00".($transData->id + 1);
            }
            else if($transData->id > 999 && $transData->id <= 9999) 
            {
                $transaction_code = "ESSKAYTRANS0".($transData->id + 1);
            }
            else
            {
                $transaction_code = "ESSKAYTRANS".($transData->id + 1);
            }
        }
        else
        {
            $transaction_code = "ESSKAYTRANS00001";
        }

        $this->crud->addField([
                                'name' => 'transaction_code',
                                'label' => 'Code',
                                'type' => 'hidden',
                                'value' => $transaction_code,
                                'tab' => 'General',
                                'attributes' => [
                                    'readonly' => 'readonly'
                                ]

        ]);

        $this->crud->addField([
                                'name' => 'transaction_live_date',
                                'label' => 'Transaction Live Date',
                                'type' => 'date',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                                'name' => 'transaction_matured_date',
                                'label' => 'Transaction Matured Date',
                                'type' => 'date',
                                'tab' => 'General'
                            ]);

        $transType = array('Live' => 'Live');
        $this->crud->addField([
                                'name' => 'transaction_type',
                                'label' => 'Transaction Status',
                                'type' => 'select_from_array',
                                'options' => $transType,
                                'tab' => 'General',
                                'attributes' => [
                                    'readonly' => 'readonly'
                                ]
                            ]);

        
        $checker_transaction = backpack_user()->hasPermissionTo('checker_transaction');
        if($checker_transaction)
        {
            $this->crud->addField([
                                'name' => 'transaction_status',
                                'label' => 'Status',
                                'type' => 'hidden',
                                'tab' => 'General'
                            ]);
        }
        else
        {
            $this->crud->addField([
                                'name' => 'transaction_status',
                                'label' => 'Status',
                                'type' => 'hidden',
                                'tab' => 'General'
                            ]);
        }

        $this->crud->addField([
                'label'     => 'Trustee',
                'type'      => 'relationship',
                'name'      => 'trustees',
                'entity'    => 'trustees', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                
                'tab' => 'Trustee'
                ]);

    }

    protected function updateTransactionFields()
    {
        $this->crud->addField([
                                'name' => 'name',
                                'label' => 'Name of Transaction',
                                'type' => 'text',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                'label'     => 'Type of Transaction',
                'type'      => 'select2',
                'name'      => 'transaction_category_id',
                'entity'    => 'transactionCategory', //function name
                'attribute' => 'category_name', //name of fields in models table like districts
                'model'     => "App\Models\TransactionCategory", //name of Models
                'tab' => 'General'
                ]);

        $checker_transaction = backpack_user()->hasPermissionTo('checker_transaction');
        $is_admin = backpack_user()->hasRole('Super Admin');

        if($is_admin)
        {
            $userData = array();
            $users = \DB::table('users')->where('user_status', '1')->get();
            foreach ($users as $key => $roww) {
                $userData[$roww->id] = $roww->name;
            }

            $this->crud->addField([
                    'label'     => 'Created By',
                    'type'      => 'select2_from_array',
                    'name'      => 'user_id',
                    'options'   => $userData,
                    'tab'       => 'General',

            ]);
        }
        else
        {
            $this->crud->addField([
                    'label'     => 'Created By',
                    'type'      => 'hidden',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models
                    'tab'       => 'General',
            ]);
        }

        $this->crud->addField([
                'name' => 'transaction_code',
                'label' => 'Code',
                'type' => 'hidden',
                'tab' => 'General',
                'attributes' => [
                    'readonly' => 'readonly'
                ]

        ]);

        $this->crud->addField([
                                'name' => 'transaction_live_date',
                                'label' => 'Transaction Live Date',
                                'type' => 'date',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                                'name' => 'transaction_matured_date',
                                'label' => 'Transaction Matured Date',
                                'type' => 'date',
                                'tab' => 'General'
                            ]);

        $transType = array('Live' => 'Live', 'Matured' => 'Matured');
        $this->crud->addField([
                                'name' => 'transaction_type',
                                'label' => 'Transaction Status',
                                'type' => 'select_from_array',
                                'options' => $transType,
                                'tab' => 'General',
                                'attributes' => [
                                    'readonly' => 'readonly'
                                ]
                            ]);

        
        if($checker_transaction)
        {
            $this->crud->addField([
                                'name' => 'transaction_status',
                                'label' => 'Status',
                                'type' => 'hidden',
                                'tab' => 'General'
                            ]);
        }
        else
        {
            $this->crud->addField([
                                'name' => 'transaction_status',
                                'label' => 'Status',
                                'type' => 'hidden',
                                'tab' => 'General'
                            ]);
        }

        $this->crud->addField([
                'label'     => 'Trustee',
                'type'      => 'relationship',
                'name'      => 'trustees',
                'entity'    => 'trustees', //function name
                'attribute' => 'name', //name of fields in models table like districts
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                
                'tab' => 'Trustee'
                ]);
    }

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $clonedEntry = $this->crud->model->findOrFail($id)->replicate();

        $lastData = \DB::table('transactions')->orderBy('id', 'DESC')->first();
        $last_id = $lastData->id;
        $last_id = $last_id+1;

        $clonedEntry->transaction_code = "ESSKAYTRANS0000".$last_id;


        return (string) $clonedEntry->push();

        // if you still want to call the old clone method
        //$this->traitClone($id);
    }
}
