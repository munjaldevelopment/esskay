<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Http\Requests\TransactionRelevantPartyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TransactionRelevantPartyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionRelevantPartyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitTransactionRelevantPartyStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitTransactionRelevantPartyUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }
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
        CRUD::setModel(\App\Models\TransactionRelevantParty::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction_relevant_party');
        CRUD::setEntityNameStrings('Transaction Relevant Party', 'Transaction Relevant Parties');
        
        $list_relevant_parties = backpack_user()->hasPermissionTo('list_relevant_parties');
        if($list_relevant_parties)
        {
            $this->crud->allowAccess('show');
            $this->crud->enableExportButtons();
            
            //$this->crud->denyAccess(['delete']);
            
            $maker_relevant_parties = backpack_user()->hasPermissionTo('maker_relevant_parties');
            if($maker_relevant_parties)
            {
                //$this->crud->addClause('whereIn', 'party_status', [0,1]);
                $this->crud->allowAccess(['create', 'update']);
            }
            else
            {
                $this->crud->denyAccess(['create', 'update', 'delete']);
            }
            
            $checker_relevant_parties = backpack_user()->hasPermissionTo('checker_relevant_parties');
            if($checker_relevant_parties)
            {
                $is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    //$this->crud->addClause('where', 'party_status', '=', "0");
                    $this->crud->allowAccess(['checker_relevant_parties', 'revise', 'delete']);
                }
                else
                {
                    $this->crud->denyAccess(['revise']);
                    $this->crud->allowAccess(['checker_relevant_parties']);
                }
            }
            else
            {
                $this->crud->denyAccess(['checker_relevant_parties', 'revise', 'delete']);
            }
            
            if($checker_relevant_parties && !$maker_relevant_parties)
            {
                //$this->crud->addClause('where', 'party_status', '=', "0");
            }
            
            $this->crud->addColumn([
                    'label'     => 'Name of Transaction',
                    'type'      => 'select',
                    'name'      => 'transaction_id',
                    'entity'    => 'transaction', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\Models\Transaction", //name of Models

                    ]);

            $this->crud->addColumn([
                                    'name' => 'party_type',
                                    'label' => 'Party Type',
                                    'type' => 'text',
                                ]);

            $this->crud->addColumn([
                    'label'     => 'Party Name',
                    'type'      => 'text',
                    'name'      => 'party_name',

                    ]);

            $this->crud->addColumn([
                    'label'     => 'Created By',
                    'type'      => 'select',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models

                    ]);

            $this->crud->addColumn([
                                    'name' => 'party_status',
                                    'label' => 'Status',
                                    'type' => 'check',
                                ]);
                                
            
            //$this->crud->enableAjaxTable();
            
            $this->crud->addFilter([
                  'type' => 'text',
                  'name' => 'document_name',
                  'label'=> 'Name'
                ],
                false,
                function($value) {
                    $this->crud->addClause('where', 'document_name', 'LIKE', "%$value%");
            });
            
            $this->crud->setCreateView('admin.create-document-form');
            $this->crud->setUpdateView('admin.edit-document-form');
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
    protected function addTransactionRelevantPartyFields()
    {
        $this->crud->addField([
                    'label'     => 'Name of Transaction',
                    'type'      => 'select2',
                    'name'      => 'transaction_id',
                    'entity'    => 'transaction', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\Models\Transaction", //name of Models

                    'attributes'   => [
                        'id' => 'transaction_id',
                    ],
                    'tab' => 'General'
                    ]);

            $documentType = array('' => 'Select', 'Investor' => 'Investor', 'Trustee' => 'Trustee', 'Legal' => 'Legal', 'Arranger' => 'Arranger', 'Rating' =>  'Rating');
            
            $this->crud->addField([
                                    'name' => 'party_type',
                                    'label' => 'Party Type',
                                    'type' => 'select2_from_array',
                                    'options' => $documentType,
                                    'tab' => 'General',
                                    'attributes' => [
                                        'id' => 'party_type',
                                        //'onchange' => 'getTransDocType(this.value);'
                                    ]
                                ]);

                    
            $this->crud->addField([
                                    'name' => 'party_name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
                                
            $document_date = array('' => 'Select');
            $year = date('Y') + 1;

            for($count=$year;$count>=2015;$count--)
            {
                $document_date[$count] = $count;
            }

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
                                    'name' => 'party_status',
                                    'label' => 'Status',
                                    'type' => 'checkbox',
                                    'tab' => 'General'
                                ]);


            $this->crud->addField([
                    'label'     => 'Lender',
                    'type'      => 'relationship',
                    'name'      => 'lenders',
                    'entity'    => 'lenders', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Lender'
                    ]);

            $this->crud->addField([
                    'label'     => 'Trustee',
                    'type'      => 'relationship',
                    'name'      => 'trustees',
                    'entity'    => 'trustees', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Trustee'
                    ]);
    }

    protected function updateTransactionRelevantPartyFields()
    {
        $this->crud->addField([
                    'label'     => 'Name of Transaction',
                    'type'      => 'select2',
                    'name'      => 'transaction_id',
                    'entity'    => 'transaction', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\Models\Transaction", //name of Models

                    'attributes'   => [
                        'id' => 'transaction_id',
                    ],
                    'tab' => 'General'
                    ]);

            $documentType = array('' => 'Select', 'Investor' => 'Investor', 'Trustee' => 'Trustee', 'Legal' => 'Legal', 'Arranger' => 'Arranger', 'Rating' =>  'Rating');

            $this->crud->addField([
                                    'name' => 'party_type',
                                    'label' => 'Party Type',
                                    'type' => 'select2_from_array',
                                    'options' => $documentType,
                                    'tab' => 'General',
                                    'attributes' => [
                                        'id' => 'party_type',
                                        //'onchange' => 'getTransDocType(this.value);'
                                    ]
                                ]);

                    
            $this->crud->addField([
                                    'name' => 'party_name',
                                    'label' => 'Name',
                                    'type' => 'text',
                                    'tab' => 'General'
                                ]);
                                
            $document_date = array('' => 'Select');

            $year = date('Y') + 1;
            for($count=$year;$count>=2015;$count--)
            {
                $document_date[$count] = $count;
            }

            $checker_transaction = backpack_user()->hasPermissionTo('checker_transaction');
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
                        'tab'       => 'General',
                ]);
            }
            
            $this->crud->addField([
                                    'name' => 'party_status',
                                    'label' => 'Status',
                                    'type' => 'checkbox',
                                    'tab' => 'General'
                                ]);


            $this->crud->addField([
                    'label'     => 'Lender',
                    'type'      => 'relationship',
                    'name'      => 'lenders',
                    'entity'    => 'lenders', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Lender'
                    ]);

            $this->crud->addField([
                    'label'     => 'Trustee',
                    'type'      => 'relationship',
                    'name'      => 'trustees',
                    'entity'    => 'trustees', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                    
                    'tab' => 'Trustee'
                    ]);
    }

    protected function setupCreateOperation()
    {
        $this->addTransactionRelevantPartyFields();
        CRUD::setValidation(TransactionRelevantPartyRequest::class);

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
        $this->updateTransactionRelevantPartyFields();
        CRUD::setValidation(TransactionRelevantPartyRequest::class);
    }

    public function store()
    {
      $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitTransactionRelevantPartyStore();

        $trustees = $this->crud->getRequest()->trustees;
        //dd($this->crud->getRequest());
        $document_id =  $this->crud->entry->id;
        $document_heading = $this->crud->getRequest()->document_heading;
        $document_name = $this->crud->getRequest()->document_name;
        $document_filename = $this->crud->getRequest()->document_filename;
        $document_date = $this->crud->getRequest()->document_date;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $party_status = $this->crud->getRequest()->party_status;


        //$lender_id = end($lenders);
        $sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            if($trustees)
            {
                foreach ($trustees as $len) {
                    $lender_id = $len;
                    $lenderData = \DB::table('trustees')->where('id', $lender_id)->first();
                    //dd($lenderData);
                    $lender_name = $lenderData->name;
                    $lender_phone = $lenderData->phone;
                    //$lender_phone = '9828807023';
                    $lender_email = $lenderData->email;
                    //$lender_email = 'ashoks.18apr@gmail.com';
                
                
                    $message = str_replace(" ", "%20", "Dear ".$lender_name.", You have assigned a document category. ");

                    $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
                    $smsresult = $this->getContent($request_url);
                    if($smsresult['errno'] == 0){
                        \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
                    }
            
            
                    // Send Mail
                    $strmsg = "Dear ".$lender_name.", You have assigned a document category. ";
                    $emailData = array('first_name' => $lender_name, 'email' => $lender_email, 'telephone' => $lender_phone, 'user_message' => $strmsg);
                    $tempUserData = array('email' => $lender_email, 'name' => $lender_name);
                    
                    Mail::send('emails.assign_doc', $emailData, function ($message) use ($tempUserData) {
                      $message->to($tempUserData['email'], $tempUserData['name'])->subject("Assign Document Category");
                      $message->cc('communication@skfin.in');
                      $message->from('communication@skfin.in', 'Ess Kay Fincorp');
                    });
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

        $result = $this->traitTransactionRelevantPartyUpdate();

        $lenders = $this->crud->getRequest()->trustees;
        //$lender_id = end($lenders);
        
        $document_id =  $this->crud->getRequest()->id;
        $document_heading = $this->crud->getRequest()->document_heading;
        $document_name = $this->crud->getRequest()->document_name;
        $document_filename = $this->crud->getRequest()->document_filename;
        $document_date = $this->crud->getRequest()->document_date;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $party_status = $this->crud->getRequest()->party_status;
        


        $sms_status = config('general.sms_status');
                
        if($sms_status)
        {
                
            if($lenders)
            {
                foreach ($lenders as $len) {
                    $lender_id = $len;
                    $lenderData = \DB::table('trustees')->where('id', $lender_id)->first();
                    //dd($lenderData);
                    $lender_name = $lenderData->name;
                    $lender_phone = $lenderData->phone;
                    //$lender_phone = '9828807023';
                    $lender_email = $lenderData->email;
                    //$lender_email = 'ashoks.18apr@gmail.com';
                
                
                    $message = str_replace(" ", "%20", "Dear ".$lender_name.", You have assigned a document.");

                    $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
                    $smsresult = $this->getContent($request_url);
                    if($smsresult['errno'] == 0){
                        \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
                    }


                    // Send Mail
                    $strmsg = "Dear ".$lender_name.", You have assigned a document. ";
                    $emailData = array('first_name' => $lender_name, 'email' => $lender_email, 'telephone' => $lender_phone, 'user_message' => $strmsg);
                    $tempUserData = array('email' => $lender_email, 'name' => $lender_name);

                    Mail::send('emails.assign_doc', $emailData, function ($message) use ($tempUserData) {
                    $message->to($tempUserData['email'], $tempUserData['name'])->subject("Assign Document");
                    $message->cc('communication@skfin.in');
                    $message->from('communication@skfin.in', 'Ess Kay Fincorp');
                    });
                    // dd($lenders);
                }
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
    
    public function checkerDocument($document_id)
    {
        $updateData = array('party_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
        \DB::table('transaction_relevant_parties')->where(['id' => $document_id])->update($updateData);
    }

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $clonedEntry = $this->crud->model->findOrFail($id)->replicate();

        $clonedEntry->party_status = "0";


        return (string) $clonedEntry->push();

        // if you still want to call the old clone method
        //$this->traitClone($id);
    }
}
