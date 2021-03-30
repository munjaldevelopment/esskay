<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OperationalHighlightRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OperationalHighlightCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OperationalHighlightCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitOperationalHighlightStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitOperationalHighlightUpdate; }
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
        CRUD::setModel(\App\Models\OperationalHighlight::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/operational_highlight');
        CRUD::setEntityNameStrings('Op. Highlight', 'Operational Highlights');
		
		$list_operational_highlight = backpack_user()->hasPermissionTo('list_operational_highlight');
		
		if($list_operational_highlight)
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
					'label'     => 'Value1 Amount',
					'type'      => 'text',
					'name'      => 'operation_row1_value',
					]);
					
			$this->crud->addColumn([
					'label'     => 'Value1 Heading',
					'type'      => 'text',
					'name'      => 'operation_row1_income',
					]);

            $this->crud->addColumn([
                    'label'     => 'Value2 Amount',
                    'type'      => 'text',
                    'name'      => 'operation_row2_value',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Value2 Heading',
                    'type'      => 'text',
                    'name'      => 'operation_row2_income',
                    ]);
					
			$this->crud->addField([
					'label'     => 'Value1 Amount',
                    'type'      => 'text',
                    'name'      => 'operation_row1_value',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Value1 Heading',
                    'type'      => 'text',
                    'name'      => 'operation_row1_income',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value1 Heading %',
                    'type'      => 'text',
                    'name'      => 'operation_row1_income_percentage',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value1 Year',
                    'type'      => 'text',
                    'name'      => 'operation_row1_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value2 Amount',
                    'type'      => 'text',
                    'name'      => 'operation_row2_value',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Value2 Heading',
                    'type'      => 'text',
                    'name'      => 'operation_row2_income',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value2 Heading %',
                    'type'      => 'text',
                    'name'      => 'operation_row2_income_percentage',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value2 Year',
                    'type'      => 'text',
                    'name'      => 'operation_row2_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Value3 Amount',
                    'type'      => 'text',
                    'name'      => 'operation_row3_value',
				]);

            $this->crud->addField([
                    'label'     => 'Value3 Year',
                    'type'      => 'text',
                    'name'      => 'operation_row3_year',
                    ]);

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'operational_highlight_status',
                ]);

            
					
			
			$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportOperationalHighlightButton', 'end');
			$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importOperationalHighlightButton', 'end');

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
        CRUD::setValidation(OperationalHighlightRequest::class);

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

        $result = $this->traitOperationalHighlightStore();

        return $result;
    }    

    public function update()
    {
      	$this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitOperationalHighlightUpdate();

        return $result;
    }
}
