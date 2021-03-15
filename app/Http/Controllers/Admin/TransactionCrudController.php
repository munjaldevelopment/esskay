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
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
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
                //$this->crud->addClause('where', 'document_status', '=', "0");
                $this->crud->allowAccess(['checker_transaction', 'revise', 'delete']);
            }
            else
            {
                $this->crud->denyAccess(['checker_transaction', 'revise', 'delete']);
            }
            
            
            $this->crud->set('reorder.label', 'name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 3);
            $this->crud->orderBy('lft', 'ASC');
            
            //$this->crud->enableReorder('name', 2);
            
            //$this->crud->denyAccess(['delete']);
            $this->crud->addColumn([
                    'label'     => 'Transaction Category',
                    'type'      => 'select',
                    'name'      => 'transaction_category_id',
                    'entity'    => 'transactionCategory', //function name
                    'attribute' => 'category_name', //name of fields in models table like districts
                    'model'     => "App\Models\TransactionCategory", //name of Models

                    ]);

            $this->crud->addColumn([
                                    'name' => 'transaction_code',
                                    'label' => 'Code',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
            $this->crud->addColumn([
                                    'name' => 'transaction_status',
                                    'label' => 'Status',
                                    'type' => 'check',
                                ]);

            
            $this->crud->addField([
                    'label'     => 'Transaction Category',
                    'type'      => 'select2',
                    'name'      => 'transaction_category_id',
                    'entity'    => 'transactionCategory', //function name
                    'attribute' => 'category_name', //name of fields in models table like districts
                    'model'     => "App\Models\TransactionCategory", //name of Models
                    'tab' => 'General'
                    ]);

            $this->crud->addField([
                    'label'     => 'Transaction Category',
                    'type'      => 'select2',
                    'name'      => 'transaction_category_id',
                    'entity'    => 'transactionCategory', //function name
                    'attribute' => 'category_name', //name of fields in models table like districts
                    'model'     => "App\Models\TransactionCategory", //name of Models
                    'tab' => 'General'
                    ]);

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

            //ESSKAYTRANS006
            $this->crud->addField([
                                    'name' => 'transaction_code',
                                    'label' => '',
                                    'type' => 'text',
                                    'value' => $transaction_code,
                                    'tab' => 'General',
                                    'attributes' => [
                                        'style' => 'display:none'
                                    ]

                                ], 'create');

            $this->crud->addField([
                                    'name' => 'transaction_code',
                                    'label' => '',
                                    'type' => 'text',
                                    'tab' => 'General',
                                    'attributes' => [
                                        'style' => 'display:none'
                                    ]
                                ], 'update');

            $this->crud->addField([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'transaction_date',
                                    'label' => 'Transaction Date',
                                    'type' => 'date',
                                    'tab' => 'General'
                                ]);

            $transType = array('Live' => 'Live', 'Matured' => 'Matured');
            $this->crud->addField([
                                    'name' => 'transaction_type',
                                    'label' => 'Transaction Type',
                                    'type' => 'select_from_array',
                                    'options' => $transType,
                                    'tab' => 'General'
                                ]);

            

            $this->crud->addField([
                                    'name' => 'transaction_status',
                                    'label' => 'Status',
                                    'type' => 'checkbox',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                    'label'     => 'Trustee',
                    'type'      => 'relationship ',
                    'name'      => 'trustees',
                    'entity'    => 'trustees', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Trustee'
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
        CRUD::setValidation(TransactionRequest::class);

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
