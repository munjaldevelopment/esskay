<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CurrentDealRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CurrentDealCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CurrentDealCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitDocumentStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitDocumentUpdate; }
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
        CRUD::setModel(\App\Models\CurrentDeal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/current_deal');
        CRUD::setEntityNameStrings('Current Deal', 'current deals');

        $list_current_deal = backpack_user()->hasPermissionTo('list_current_deal');

        

           

        if($list_current_deal)
        {
            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();
            
            //$this->crud->denyAccess(['delete']);
            
            $maker_current_deal = backpack_user()->hasPermissionTo('maker_current_deal');
            if($maker_current_deal)
            {
                //$this->crud->addClause('whereIn', 'status', [0,1]);
                $this->crud->allowAccess(['create', 'update']);
            }
            else
            {
                $this->crud->denyAccess(['create', 'update', 'delete']);
            }
            
            $checker_current_deal = backpack_user()->hasPermissionTo('checker_current_deal');
            if($checker_current_deal)
            {
                //$this->crud->addClause('where', 'status', '=', "0");
                $this->crud->allowAccess(['checker_current_deal', 'revise', 'delete']);
            }
            else
            {
                $this->crud->denyAccess(['checker_current_deal', 'revise', 'delete']);
            }
            
            if($checker_current_deal && !$maker_current_deal)
            {
                $this->crud->addClause('where', 'status', '=', "0");
            }
             $this->crud->addButtonFromView('line', 'checker_current_deal', 'checker_current_deal', 'end');
            $this->crud->addColumn([
                    'label'     => 'Deal Category',
                    'type'      => 'select',
                    'name'      => 'current_deal_category_id',
                    'entity'    => 'currentDealCateogry', //function name
                    'attribute' => 'category_name', //name of fields in models table like districts
                    'model'     => "App\Models\CurrentDealCategory", //name of Models

                    ]);
                    
            $this->crud->addColumn([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                ]);
                                
            $this->crud->addColumn([
                                     'name' => 'current_deal_code',
                                    'label' => 'Deal Code',
                                    'type' => 'text',
                                ]);
                                
            $current_deal_categories = array();
            
            $current_deal_categories[0] = 'Select';
            $parent = \DB::table('current_deal_categories')->whereNull('parent_id')->orderBy('lft')->get();
            if($parent)
            {
                foreach($parent as $row)
                {
                    $current_deal_categories[$row->id] = $row->category_name;
                }
            }
            //echo '<pre>';print_r($current_deal_categories); exit;
            
            $this->crud->addField([
                    'label'     => 'Deal Category',
                    'type'      => 'select2_from_array',
                    'name'      => 'current_deal_category_id',
                    'options'   => $current_deal_categories,
                    'attributes'   => [
                        'id' => 'current_deal_category_id',
                    ],
                    'tab' => 'General'
                    ]);
                    
            $this->crud->addField([
                                    'name' => 'current_deal_code',
                                    'label' => 'Deal Code',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
                    
            $this->crud->addField([
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'rating',
                                    'label' => 'Rating',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'amount',
                                    'label' => 'Amount',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'pricing',
                                    'label' => 'Pricing',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'tenure',
                                    'label' => 'Tenure',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'select2_from_array',
                                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject'),
                                    'tab' => 'General'

                                 ]);
            

            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportCurrentDealButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importCurrentDealButton', 'end');
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
        CRUD::setValidation(CurrentDealRequest::class);

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
