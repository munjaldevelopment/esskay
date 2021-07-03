<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommitteeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommitteeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommitteeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitCommitteeStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitCommitteeUpdate; }

    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    use \Backpack\ReviseOperation\ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Committee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/committee');
        CRUD::setEntityNameStrings('Committee', 'Committee');

        $list_committee = backpack_user()->hasPermissionTo('list_committee');
        
        if($list_committee)
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

            $checker_committee = backpack_user()->hasPermissionTo('checker_committee');

            if($checker_committee)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_committee', 'revise', 'delete']);
                }
                else
                {
                    if($checker_committee)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_committee']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_committee', 'revise', 'delete']);
            }

            $this->crud->addColumn([
                    'label'     => 'Composition Heading',
                    'type'      => 'text',
                    'name'      => 'composition_heading',
                    ]);
                    
            $this->crud->addColumn([
                    'label'     => 'Director Name',
                    'type'      => 'text',
                    'name'      => 'director_name',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Stataus',
                    'type'      => 'text',
                    'name'      => 'status',
                    ]);

            $this->crud->addColumn([
                    'label'     => 'Status',
                    'type'      => 'check',
                    'name'      => 'committee_status',
                ]);
                    
            $composition_heading = array('Asset Liability' => 'Asset Liability', 'Audit Committee' => 'Audit Committee', 'Board of Directors' => 'Board of Directors', 'Corporate Social Responsibility Committee' => 'Corporate Social Responsibility Committee', 'Executive Committee' => 'Executive Committee', 'IT Strategy Committee' => 'IT Strategy Committee', 'Nomination & Remuneration Committee' => 'Nomination & Remuneration Committee', 'Risk Management Committee' => 'Risk Management Committee');

            $this->crud->addField([
                    'label'     => 'Composition Heading',
                    'type'      => 'select2_from_array',
                    'name'      => 'composition_heading',
                    'options'   => $composition_heading
                    ]);

            $this->crud->addField([
                    'label'     => 'Director Name',
                    'type'      => 'text',
                    'name'      => 'director_name',
                    ]);

            $status = array('Chairman' => 'Chairman', 'CIO' => 'CIO', 'CTO' => 'CTO', 'Member' => 'Member');
            $this->crud->addField([
                    'label'     => 'Stataus',
                    'type'      => 'select2_from_array',
                    'name'      => 'status',
                    'options'   => $status
                    ]); 

            $nature_directorship = array('CFO' => 'CFO', 'Executive Director' => 'Executive Director', 'Head Treasury' => 'Head Treasury', 'NA' => 'NA', 'Nominee Director' => 'Nominee Director', 'Non Executive Independent Director' => 'Non Executive Independent Director');
            $this->crud->addField([
                    'label'     => 'Nature Directorship',
                    'type'      => 'select2_from_array',
                    'name'      => 'nature_directorship',
                    'options'   => $nature_directorship
                    ]);

           
            
             $this->crud->addField([
                    'label'     => 'Status',
                    'type'      => 'select2_from_array',
                    'name'      => 'committee_status',
                    'options'   => array('0' => 'Pending', '1' => 'Accept', '2' => 'Reject')
                ]);
            //$this->crud->addButtonFromModelFunction('top', 'export_xls', 'exportStrongLiabilityDrivingButton', 'end');
            //$this->crud->addButtonFromModelFunction('top', 'import_xls', 'importStrongLiabilityDrivingButton', 'end');

            //$this->crud->addButtonFromView('line', 'checker_committee', 'checker_committee', 'end');

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
        CRUD::setValidation(CommitteeRequest::class);

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

        $result = $this->traitCommitteeStore();

        return $result;
    }    

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitCommitteeUpdate();

        return $result;
    }
}
