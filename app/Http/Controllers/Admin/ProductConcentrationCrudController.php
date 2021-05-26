<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductConcentrationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductConcentrationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductConcentrationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitProductConcentrationStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitProductConcentrationUpdate; }
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
        CRUD::setModel(\App\Models\ProductConcentration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product_concentration');
        CRUD::setEntityNameStrings('Product Con.', 'Product Concentrations');

        $list_product_concentration = backpack_user()->hasPermissionTo('list_product_concentration');
        
        if($list_product_concentration)
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
            
            $checker_product_concentration = backpack_user()->hasPermissionTo('checker_product_concentration');

            if($checker_product_concentration)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_product_concentration', 'revise', 'delete']);
                }
                else
                {
                    if($checker_product_concentration)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_product_concentration']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_product_concentration', 'revise', 'delete']);
            }

            $this->crud->addColumn([
                    'label'     => 'Product Diversification',
                    'type'      => 'text',
                    'name'      => 'product_diversification',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Mar-16 Amount',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Mar-16 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);
                    
            $geographicalDivData = array('Commercial Vehicle' => 'Commercial Vehicle', 'Tractor' => 'Tractor', 'Car' => 'Car', 'Two Wheeler' => 'Two Wheeler', 'SME' => 'SME');
                    
            $this->crud->addField([
                    'label'     => 'Product Diversification',
                    'type'      => 'select2_from_array',
                    'name'      => 'product_diversification',
                    'options'   => $geographicalDivData
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-16 Amount',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-16 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-17 Amount',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-17 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-18 Amount',
                    'type'      => 'text',
                    'name'      => 'amount3',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-18 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage3',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-19 Amount',
                    'type'      => 'text',
                    'name'      => 'amount4',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-19 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage4',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-20 Amount',
                    'type'      => 'text',
                    'name'      => 'amount5',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-20 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage5',
                    ]);

            $this->crud->addField([
                    'label'     => 'Sep-20 Amount',
                    'type'      => 'text',
                    'name'      => 'amount6',
                    ]);

            $this->crud->addField([
                    'label'     => 'Sep-20 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage6',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-21 Amount',
                    'type'      => 'text',
                    'name'      => 'amount7',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-21 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage7',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-22 Amount',
                    'type'      => 'text',
                    'name'      => 'amount8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-22 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-23 Amount',
                    'type'      => 'text',
                    'name'      => 'amount9',
                    ]);

            $this->crud->addField([
                    'label'     => 'Mar-23 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage9',
                    ]);

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'product_concentration_status',
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportProductConcentrationButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importProductConcentrationButton', 'end');

            $this->crud->addButtonFromView('line', 'checker_product_concentration', 'checker_product_concentration', 'end');
            
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
        CRUD::setValidation(ProductConcentrationRequest::class);

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

        $result = $this->traitProductConcentrationStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitProductConcentrationUpdate();

        return $result;
    }
}
