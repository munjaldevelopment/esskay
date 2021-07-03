<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganisationStructureRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganisationStructureCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganisationStructureCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitOrganisationStructureStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitOrganisationStructureUpdate; }

    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
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
        CRUD::setModel(\App\Models\OrganisationStructure::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organisation_structure');
        CRUD::setEntityNameStrings('Organisation Structure', 'Organisation Structure');

        $list_organisation_structures = backpack_user()->hasPermissionTo('list_organisation_structures');
        
        if($list_organisation_structures)
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

            $this->crud->set('reorder.label', 'structure_name');
            // define how deep the admin is allowed to nest the items
            // for infinite levels, set it to 0
            $this->crud->set('reorder.max_level', 4);
            $this->crud->orderBy('lft', 'ASC');

            $checker_organisation_structures = backpack_user()->hasPermissionTo('checker_organisation_structures');

            if($checker_organisation_structures)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_organisation_structures', 'revise', 'delete']);
                }
                else
                {
                    if($checker_organisation_structures)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_organisation_structures']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_organisation_structures', 'revise', 'delete']);
            }
                    
            $this->crud->addColumn([
                    'label'     => 'Structure Code',
                    'type'      => 'text',
                    'name'      => 'structure_code',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Structure Name',
                    'type'      => 'text',
                    'name'      => 'structure_name',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Stataus',
                    'type'      => 'check',
                    'name'      => 'status',
                    ]);


            $this->crud->addField([
                     'label'     => 'Structure Code',
                    'type'      => 'text',
                    'name'      => 'structure_code',
                    ]);

            $this->crud->addField([
                    'label'     => 'Structure Name',
                    'type'      => 'text',
                    'name'      => 'structure_name',
                    ]);

            $this->crud->addField([
                    'label'     => 'Stataus',
                    'type'      => 'checkbox',
                    'name'      => 'status',
                    ]);

            //$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityDrivingButton', 'end');
            //$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityDrivingButton', 'end');

            //$this->crud->addButtonFromView('line', 'checker_organisation_structures', 'checker_organisation_structures', 'end');

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
        CRUD::setValidation(OrganisationStructureRequest::class);

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

        $result = $this->traitOrganisationStructureStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitOrganisationStructureUpdate();

        return $result;
    }

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'structure_name');
        CRUD::set('reorder.max_level', 2);
    }
}
