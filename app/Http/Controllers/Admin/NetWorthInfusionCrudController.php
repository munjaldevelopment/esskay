<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NetWorthInfusionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NetWorthInfusionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NetWorthInfusionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
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
        CRUD::setModel(\App\Models\NetWorthInfusion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/networth_infusion');
        CRUD::setEntityNameStrings('Networth Infusion', 'Net Worth Infusions');

        $list_net_worth_infusion = backpack_user()->hasPermissionTo('list_net_worth_infusion');
        
        if($list_net_worth_infusion)
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
                    'label'     => 'Month',
                    'type'      => 'text',
                    'name'      => 'month',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Capital Infusion',
                    'type'      => 'text',
                    'name'      => 'capital_infusion',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Month',
                    'type'      => 'text',
                    'name'      => 'month',
                    ]);

            $this->crud->addField([
                    'label'     => 'Capital Infusion',
                    'type'      => 'text',
                    'name'      => 'capital_infusion',
                    ]);

            $this->crud->addField([
                    'label'     => 'Investors',
                    'type'      => 'ckeditor',
                    'name'      => 'investors',
                    ]);

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'net_worth_infusion_status',
                ]);
            
            //$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportNetWorthButton', 'end');
            //$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importNetWorthButton', 'end');

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
        CRUD::setValidation(NetWorthInfusionRequest::class);

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
