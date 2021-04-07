<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AssetQualityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AssetQualityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AssetQualityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitAssetQualityStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitAssetQualityUpdate; }
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
        CRUD::setModel(\App\Models\AssetQuality::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/asset_quality');
        CRUD::setEntityNameStrings('Asset Quality', 'Asset Qualities');

        $list_asset_quality = backpack_user()->hasPermissionTo('list_asset_quality');
        
        if($list_asset_quality)
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
                    'label'     => 'FY14 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'FY15 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage2',
                    ]);
                    
            $this->crud->addField([
                    'label'     => 'Geographical Diversification',
                    'type'      => 'text',
                    'name'      => 'geographical_diversification',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY14 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage1',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY15 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage2',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY16 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage3',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY17 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage4',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY18 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage5',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY19 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage6',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY20 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage7',
                    ]);

            $this->crud->addField([
                    'label'     => 'FY21 Amount %',
                    'type'      => 'text',
                    'name'      => 'amount_percentage8',
                    ]);

            $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'checkbox',
                    'name'      => 'asset_quality_status',
                ]);
            
            $this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportAssetQualityButton', 'end');
            $this->crud->addButtonFromModelFunction('top', 'import_xls', 'importAssetQualityButton', 'end');

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
        CRUD::setValidation(AssetQualityRequest::class);

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

        $result = $this->traitAssetQualityStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitAssetQualityUpdate();

        return $result;
    }
}
