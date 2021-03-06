<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GeographicalConcentrationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GeographicalConcentrationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GeographicalConcentrationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitGeographicalConcentrationStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitGeographicalConcentrationUpdate; }
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
        CRUD::setModel(\App\Models\GeographicalConcentration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/geographical_concentration');
        CRUD::setEntityNameStrings('Geographical Concentration', 'Geographical Concentrations');

        $list_geographical_concentration = backpack_user()->hasPermissionTo('list_geographical_concentration');
        
        if($list_geographical_concentration)
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
                    'label'     => 'Geographical Diversification',
                    'type'      => 'text',
                    'name'      => 'geographical_diversification',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Amount1',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Amount Percentage1',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Geographical Diversification',
                    'type'      => 'text',
                    'name'      => 'geographical_diversification',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount1',
                    'type'      => 'text',
                    'name'      => 'amount1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage1',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount2',
                    'type'      => 'text',
                    'name'      => 'amount2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage2',
                    'type'      => 'text',
                    'name'      => 'amount_percentage2',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount3',
                    'type'      => 'text',
                    'name'      => 'amount3',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage3',
                    'type'      => 'text',
                    'name'      => 'amount_percentage3',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount4',
                    'type'      => 'text',
                    'name'      => 'amount4',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage4',
                    'type'      => 'text',
                    'name'      => 'amount_percentage4',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount5',
                    'type'      => 'text',
                    'name'      => 'amount5',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage5',
                    'type'      => 'text',
                    'name'      => 'amount_percentage5',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount6',
                    'type'      => 'text',
                    'name'      => 'amount6',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage6',
                    'type'      => 'text',
                    'name'      => 'amount_percentage6',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount7',
                    'type'      => 'text',
                    'name'      => 'amount7',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage7',
                    'type'      => 'text',
                    'name'      => 'amount_percentage7',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount8',
                    'type'      => 'text',
                    'name'      => 'amount8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage8',
                    'type'      => 'text',
                    'name'      => 'amount_percentage8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount9',
                    'type'      => 'text',
                    'name'      => 'amount9',
                    ]);

            $this->crud->addField([
                    'label'     => 'Amount Percentage9',
                    'type'      => 'text',
                    'name'      => 'amount_percentage9',
                    ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportGeographicalConcentrationButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importGeographicalConcentrationButton', 'end');

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
        CRUD::setValidation(GeographicalConcentrationRequest::class);

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

        $result = $this->traitGeographicalConcentrationStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitGeographicalConcentrationUpdate();

        return $result;
    }
}
