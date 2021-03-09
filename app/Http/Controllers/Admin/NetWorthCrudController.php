<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NetWorthRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NetWorthCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NetWorthCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitNetWorthStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitNetWorthUpdate; }
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
        CRUD::setModel(\App\Models\NetWorth::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/net_worth');
        CRUD::setEntityNameStrings('Net Worth', 'Net Worths');

        $list_net_worth = backpack_user()->hasPermissionTo('list_net_worth');
        
        if($list_net_worth)
        {
            $adminRolesRow  = \DB::table('model_has_roles')->where('role_id', '=', '1')->get();
            
            $adminRolesData = array();
            foreach($adminRolesRow as $row)
            {
                $adminRolesData[] = $row->model_id;
            }
            
            $this->crud->orderBy('updated_at', 'DESC');
            
            
            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();
            
            $this->crud->addColumn([
                    'label'     => 'Particulars',
                    'type'      => 'text',
                    'name'      => 'particulars',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Top FY16 Amount',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Top FY17 Amount',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Particulars',
                    'type'      => 'text',
                    'name'      => 'particulars',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY16 Amount',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY17 Amount',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY18 Amount',
                    'type'      => 'text',
                    'name'      => 'amount3',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY19 Amount',
                    'type'      => 'text',
                    'name'      => 'amount4',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY20 Amount',
                    'type'      => 'text',
                    'name'      => 'amount5',
                    ]);

            $this->crud->addField([
                    'label'     => 'Top FY21 Amount',
                    'type'      => 'text',
                    'name'      => 'amount6',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY16 Amount',
                    'type'      => 'text',
                    'name'      => 'amount7',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY17 Amount',
                    'type'      => 'text',
                    'name'      => 'amount8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY18 Amount',
                    'type'      => 'text',
                    'name'      => 'amount9',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY19 Amount',
                    'type'      => 'text',
                    'name'      => 'amount10',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY20 Amount',
                    'type'      => 'text',
                    'name'      => 'amount11',
                    ]);

            $this->crud->addField([
                    'label'     => 'Bottom FY21 Amount',
                    'type'      => 'text',
                    'name'      => 'amount12',
                    ]);

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'net_worth_status',
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportNetWorthButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importNetWorthButton', 'end');

            $this->crud->setCreateView('admin.create-lender-banking-form');
            $this->crud->setUpdateView('admin.edit-lender-banking-form');
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
        CRUD::setValidation(NetWorthRequest::class);

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

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitNetWorthStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitNetWorthUpdate();

        return $result;
    }
}
