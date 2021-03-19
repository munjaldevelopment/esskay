<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SanctionLetterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SanctionLetterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SanctionLetterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitSanctionLetterStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitSanctionLetterUpdate; }
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
        CRUD::setModel(\App\Models\SanctionLetter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sanction_letter');
        CRUD::setEntityNameStrings('Sanction Letter', 'Sanction Letters');

        $list_sanction_letter = backpack_user()->hasPermissionTo('list_sanction_letter');
        if($list_sanction_letter)
        {
            //$this->crud->denyAccess(['create']);

            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();
            
            //$this->crud->denyAccess(['delete']);
            
            $maker_sanction_letter = backpack_user()->hasPermissionTo('maker_sanction_letter');
            if($maker_sanction_letter)
            {
                //$this->crud->addClause('whereIn', 'status', [0,1]);
                $this->crud->allowAccess(['create', 'update']);
            }
            else
            {
                $this->crud->denyAccess(['create', 'update', 'delete']);
            }
            
            $checker_sanction_letter1 = backpack_user()->hasPermissionTo('checker_sanction_letter1');
            $checker_sanction_letter2 = backpack_user()->hasPermissionTo('checker_sanction_letter2');
            $checker_sanction_letter3 = backpack_user()->hasPermissionTo('checker_sanction_letter3');

            if($checker_sanction_letter1 || $checker_sanction_letter2 || $checker_sanction_letter3)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    $this->crud->allowAccess(['checker_sanction_letter1', 'checker_sanction_letter2', 'checker_sanction_letter3', 'revise', 'delete']);
                }
                else
                {
                    if($checker_sanction_letter1)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_sanction_letter1']);
                    }
                    else if($checker_sanction_letter2)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_sanction_letter2']);
                    }
                    else if($checker_sanction_letter3)
                    {
                        //$this->crud->addClause('where', 'status', '=', "0");
                        $this->crud->denyAccess(['revise']);
                        $this->crud->allowAccess(['checker_sanction_letter3']);
                    }
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_sanction_letter1', 'checker_sanction_letter2', 'checker_sanction_letter3', 'revise', 'delete']);
            }
            
            if($checker_sanction_letter1 && !$maker_sanction_letter)
            {
                //$this->crud->addClause('where', 'status', '=', "0");
            }

            $this->crud->addColumn([
                    'label'     => 'Created By',
                    'type'      => 'select',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models

                    ]);
            
            $this->crud->addColumn([
                                    'name' => 'bank_name',
                                    'label' => 'Bank Name',
                                    'type' => 'text',
                                ]);
                                
            $this->crud->addColumn([
                                    'name' => 'type_facility',
                                    'label' => 'Facility Type',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'facility_amount',
                                    'label' => 'Facility Amount',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'roi',
                                    'label' => 'ROI',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'all_incluside_roi',
                                    'label' => 'All Inside ROI',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                                    'name' => 'processing_fees',
                                    'label' => 'Processing Fee',
                                    'type' => 'text',
                                ]);
                        
            $is_admin = backpack_user()->hasRole('Super Admin');

            if($is_admin)
            {
                $userData = array();
                $users = \DB::table('users')->where('user_status', '1')->get();
                foreach ($users as $key => $roww) {
                    $userData[$roww->id] = $roww->name;
                }

                $this->crud->addField([
                        'label'     => 'Created By',
                        'type'      => 'select2_from_array',
                        'name'      => 'user_id',
                        'options'   => $userData,
                        'tab'       => 'General',

                ]);
            }
            else
            {
                $this->crud->addField([
                        'label'     => 'Created By',
                        'type'      => 'hidden',
                        'name'      => 'user_id',
                        'entity'    => 'user', //function name
                        'attribute' => 'name', //name of fields in models table like districts
                        'model'     => "App\User", //name of Models
                        'value'     => backpack_user()->id, //name of Models
                        'tab'       => 'General'
                ]);
            }        
            
                    
            $this->crud->addField([
                                    'name' => 'bank_name',
                                    'label' => 'Bank Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
                    
            $this->crud->addField([
                                    'name' => 'type_facility',
                                    'label' => 'Type of Facility',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'facility_amount',
                                    'label' => 'Facility Amount',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'roi',
                                    'label' => 'ROI',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'all_incluside_roi',
                                    'label' => 'All-inclusive ROI',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'processing_fees',
                                    'label' => 'Processing Fees',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'arranger_fees',
                                    'label' => 'Arranger Fees',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'stamp_duty_fees',
                                    'label' => 'Stamp Duty Fees',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'tenor',
                                    'label' => 'Tenor',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'security_cover',
                                    'label' => 'Security Cover',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'cash_collateral',
                                    'label' => 'Cash Collateral',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'personal_guarantee',
                                    'label' => 'Personal Guarantee',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'intermediary',
                                    'label' => 'Intermediary',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'sanction_letter',
                                    'label' => 'Sanction Letter',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);

            $this->crud->addField([
                                    'name' => 'status',
                                    'label' => 'Status',
                                    'type' => 'select2_from_array',
                                    'options' => ['0' => 'Inactive', '1' => 'Active'],
                                    'tab' => 'Approve'
                                ]);

            $this->crud->addButtonFromView('line', 'checker_sanction_letter', 'checker_sanction_letter', 'end');
            
            $this->crud->setCreateView('admin.create-document-form');
            $this->crud->setUpdateView('admin.edit-document-form');
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
        CRUD::setValidation(SanctionLetterRequest::class);

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
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitSanctionLetterStore();

        $sanction_letter_id =  $this->crud->entry->id;
        $bank_name = $this->crud->getRequest()->bank_name;
        $type_facility = $this->crud->getRequest()->type_facility;
        $facility_amount = $this->crud->getRequest()->facility_amount;
        $roi = $this->crud->getRequest()->roi;
        $all_incluside_roi = $this->crud->getRequest()->all_incluside_roi;

        $processing_fees = $this->crud->getRequest()->processing_fees;
        $arranger_fees = $this->crud->getRequest()->arranger_fees;
        $stamp_duty_fees = $this->crud->getRequest()->stamp_duty_fees;
        $tenor = $this->crud->getRequest()->tenor;
        $security_cover = $this->crud->getRequest()->security_cover;
        $cash_collateral = $this->crud->getRequest()->cash_collateral;
        $personal_guarantee = $this->crud->getRequest()->personal_guarantee;
        $intermediary = $this->crud->getRequest()->intermediary;
        $sanction_letter = $this->crud->getRequest()->sanction_letter;


        $sanction_letter_status = $this->crud->getRequest()->status;


        \DB::table('sanction_letter_revisions')->insert(['sanction_letter_id' => $sanction_letter_id, 'bank_name' => $bank_name, 'type_facility' => $type_facility, 'facility_amount' => $facility_amount, 'roi' => $roi, 'all_incluside_roi' => $all_incluside_roi, 'processing_fees' => $processing_fees, 'arranger_fees' => $arranger_fees, 'stamp_duty_fees' => $stamp_duty_fees, 'tenor' => $tenor, 'security_cover' => $security_cover, 'cash_collateral' => $cash_collateral, 'personal_guarantee' => $personal_guarantee, 'intermediary' => $intermediary, 'sanction_letter' => $sanction_letter, 'sanction_letter_status' => $sanction_letter_status]);

        $sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear, Saction Letter has been created. ");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }

        return $result;
    }

    public function update()
    {
        $user_logged_id = \Auth::user()->id;
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitSanctionLetterUpdate();

        // To Do
        $sanction_letter_id =  $this->crud->getRequest()->id;
        $bank_name = $this->crud->getRequest()->bank_name;
        $type_facility = $this->crud->getRequest()->type_facility;
        $facility_amount = $this->crud->getRequest()->facility_amount;
        $roi = $this->crud->getRequest()->roi;
        $all_incluside_roi = $this->crud->getRequest()->all_incluside_roi;
                          
        $processing_fees = $this->crud->getRequest()->processing_fees;
        $arranger_fees = $this->crud->getRequest()->arranger_fees;
        $stamp_duty_fees = $this->crud->getRequest()->stamp_duty_fees;
        $tenor = $this->crud->getRequest()->tenor;
        $security_cover = $this->crud->getRequest()->security_cover;
        $cash_collateral = $this->crud->getRequest()->cash_collateral;
        $personal_guarantee = $this->crud->getRequest()->personal_guarantee;
        $intermediary = $this->crud->getRequest()->intermediary;
        $sanction_letter = $this->crud->getRequest()->sanction_letter;
        $sanction_letter_status = $this->crud->getRequest()->status;


        \DB::table('sanction_letter_revisions')->insert(['sanction_letter_id' => $sanction_letter_id, 'bank_name' => $bank_name, 'type_facility' => $type_facility, 'facility_amount' => $facility_amount, 'roi' => $roi, 'all_incluside_roi' => $all_incluside_roi, 'processing_fees' => $processing_fees, 'arranger_fees' => $arranger_fees, 'stamp_duty_fees' => $stamp_duty_fees, 'tenor' => $tenor, 'security_cover' => $security_cover, 'cash_collateral' => $cash_collateral, 'personal_guarantee' => $personal_guarantee, 'intermediary' => $intermediary, 'sanction_letter' => $sanction_letter, 'sanction_letter_status' => $sanction_letter_status]);

        $sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear, Saction Letter has been updated. ");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
        
        return $result;
    }

    public function getContent($request_url)
    {
        $options = array(
          CURLOPT_RETURNTRANSFER => true,     // return web page
          CURLOPT_HEADER         => false,    // don't return headers
          CURLOPT_FOLLOWLOCATION => true,     // follow redirects
          CURLOPT_ENCODING       => "",       // handle all encodings
          CURLOPT_USERAGENT      => "spider", // who am i
          CURLOPT_AUTOREFERER    => true,     // set referer on redirect
          CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
          CURLOPT_TIMEOUT        => 120,      // timeout on response
          CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
          CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch      = curl_init( $request_url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        
        //echo '<pre>';print_r($header); exit;
        return $header;
    }
}
