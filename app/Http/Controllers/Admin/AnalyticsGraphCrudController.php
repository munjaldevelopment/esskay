<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnalyticsGraphRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AnalyticsGraphCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AnalyticsGraphCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitLenderStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitLenderUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
	
	use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\AnalyticsGraph::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/analytics_graph');
        CRUD::setEntityNameStrings('analytics graph', 'analytics graphs');
		
		$this->crud->allowAccess('show');
		$this->crud->allowAccess('reorder');
		$this->crud->enableExportButtons();
		
		$this->crud->denyAccess(['create', 'delete']);
		
		$this->crud->set('reorder.label', 'analytics_title');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 3);
        $this->crud->orderBy('lft', 'ASC');
		
		$this->crud->addColumn([
                                'name' => 'analytics_title',
                                'label' => 'Title',
                                'type' => 'text',
                            ]);
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
		$this->addGraphFields();
        CRUD::setValidation(AnalyticsGraphRequest::class);

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
		$this->updateGraphFields();
        $this->setupCreateOperation();
    }
	
	protected function addGraphFields()
    {
		$this->crud->addField([
                                'name' => 'analytics_title',
                                'label' => 'Title',
                                'type' => 'text',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                                'name' => 'analytics_Ylable',
                                'label' => 'Y axis Text',
                                'type' => 'text',
                                'tab' => 'General'
                            ]);

        $this->crud->addField([
                                'name' => 'remarks',
                                'label' => 'Remarks',
                                'type' => 'ckeditor',
								'tab' => 'General'
                            ]);
							
		$this->crud->addField([
                                'name' => 'graph_details',
                                'label' => 'Graph Details',
                                'type' => 'graph_detail',
								'allows_multiple' => 'true',
								'tab' 	=> 'Details',
                            ]);
	}
	
	protected function updateGraphFields()
    {
		$this->crud->addField([
                                'name' => 'analytics_title',
                                'label' => 'Title',
                                'type' => 'text',
								'tab' => 'General'
                            ]);

        $this->crud->addField([
                                'name' => 'analytics_Ylable',
                                'label' => 'Y axis Text',
                                'type' => 'text',
                                'tab' => 'General'
                            ]);
        
        $this->crud->addField([
                                'name' => 'remarks',
                                'label' => 'Remarks',
                                'type' => 'ckeditor',
								'tab' => 'General'
                            ]);
							
		$this->crud->addField([
                                'name' => 'graph_details',
                                'label' => 'Graph Details',
                                'type' => 'graph_detail_edit',
								'allows_multiple' => 'true',
								'tab' 	=> 'Details',
                            ]);
	}
	
	public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
		
		$result = $this->traitLenderStore();
		
		// Save Data in user table
		$id = $this->crud->entry->id;
		
		if($this->crud->getRequest()->graph_details_graph_category)
		{
			foreach($this->crud->getRequest()->graph_details_graph_category as $k => $graph_details_graph_category)
			{
				if(!is_null($graph_details_graph_category))
				{
					\DB::table('analytics_graph_details')->insert(['analytics_graph_id' => $id, 'graph_category' => $graph_details_graph_category, 'graph_value' => $this->crud->getRequest()->graph_details_graph_value[$k], 'graph_heading' => $this->crud->getRequest()->graph_details_graph_heading[$k], 'graph_category1' => $this->crud->getRequest()->graph_details_graph_category1[$k], 'graph_value1' => $this->crud->getRequest()->graph_details_graph_value1[$k], 'graph_heading1' => $this->crud->getRequest()->graph_details_graph_heading1[$k], 'graph_category2' => $this->crud->getRequest()->graph_details_graph_category2[$k], 'graph_value2' => $this->crud->getRequest()->graph_details_graph_value2[$k], 'graph_heading2' => $this->crud->getRequest()->graph_details_graph_heading2[$k],  'created_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
		
		return $result;
	}
	
	public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitLenderUpdate();
		
		if($this->crud->getRequest()->graph_details_graph_category)
		{
			\DB::table('analytics_graph_details')->where('analytics_graph_id', $this->crud->getRequest()->id)->delete();
			
			foreach($this->crud->getRequest()->graph_details_graph_category as $k => $graph_details_graph_category)
			{
				if(!is_null($graph_details_graph_category))
				{
					\DB::table('analytics_graph_details')->insert(['analytics_graph_id' => $this->crud->getRequest()->id, 'graph_category' => $graph_details_graph_category, 'graph_value' => $this->crud->getRequest()->graph_details_graph_value[$k], 'graph_heading' => $this->crud->getRequest()->graph_details_graph_heading[$k], 'graph_category1' => $this->crud->getRequest()->graph_details_graph_category1[$k], 'graph_value1' => $this->crud->getRequest()->graph_details_graph_value1[$k], 'graph_heading1' => $this->crud->getRequest()->graph_details_graph_heading1[$k], 'graph_category2' => $this->crud->getRequest()->graph_details_graph_category2[$k], 'graph_value2' => $this->crud->getRequest()->graph_details_graph_value2[$k], 'graph_heading2' => $this->crud->getRequest()->graph_details_graph_heading2[$k], 'created_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
		
		return $result;
	}
}
