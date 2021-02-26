<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Http\Requests\DocumentCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitDocumentCategoryStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitDocumentCategoryUpdate; }
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
        CRUD::setModel(\App\Models\DocumentCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document_category');
        CRUD::setEntityNameStrings('Document Category', 'Document Categories');
		
		$list_document_category = backpack_user()->hasPermissionTo('list_document_category');
		
		if($list_document_category)
		{
			$this->crud->allowAccess('show');
			$this->crud->allowAccess('reorder');
			$this->crud->enableExportButtons();
			
			$this->crud->set('reorder.label', 'name');
			// define how deep the admin is allowed to nest the items
			// for infinite levels, set it to 0
			$this->crud->set('reorder.max_level', 3);
			$this->crud->orderBy('lft', 'ASC');
			
			//$this->crud->enableReorder('category_name', 2);
			
			//$this->crud->denyAccess(['delete']);
			
			$this->crud->addColumn([
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
								]);
			$this->crud->addColumn([
									'name' => 'is_timeline',
									'label' => 'Timeline Show',
									'type' => 'check',
								]);
								
			$this->crud->addColumn([
									'name' => 'category_icon',
									'label' => 'Icon',
									'type' => 'icon_picker',
								]);

			$this->crud->addColumn([
									'name' => 'category_image',
									'label' => 'Image',
									'type' => 'image',
								]);

			
								
			$this->crud->addField([
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
									'tab' => 'General'
								]);

			$this->crud->addField([
									'name' => 'document_category_guide',
									'label' => 'Document Category Guide',
									'type' => 'text',
									'tab' => 'General'
								]);


			$this->crud->addField([
									'name' => 'is_timeline',
									'label' => 'Timeline Show',
									'type' => 'select2_from_array',
									'options' => ['0' => 'No', '1' => 'Yes'],
									'tab' => 'General'
								]);
								
			$this->crud->addField([
									'name' => 'category_icon',
									'label' => 'Icon',
									'type'    => 'icon_picker',
									'iconset' => 'fontawesome', // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
									'tab' => 'General'
								]);

			$this->crud->addField([
									'name' => 'category_image',
									'label' => 'Image',
									'type' => 'browse',
									'tab' => 'General'
								]);
								
			$this->crud->addField([
									'name' => 'category_content_type',
									'label' => 'Content Type',
									'type' => 'select2_from_array',
									'options' => ['Sheet' => 'Sheet', 'Document' => 'Document'],
									'tab' => 'General'
								]);

			$this->crud->addField([
					'label'     => 'Lender',
					'type'      => 'relationship ',
					'name'      => 'lenders',
					'entity'    => 'lenders', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
					
					'tab' => 'Lender'
					]);
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
        CRUD::setValidation(DocumentCategoryRequest::class);

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
        $this->setupCreateOperation();
    }
	
	public function getSubCategory($document_category_id)
    {
        $personInfo = \DB::table("document_category")
                    ->where("parent_id",$document_category_id)
                    ->get();
					
		$personInfoData = array();
		foreach($personInfo as $row)
		{
			$personInfoData[$row->id] = $row->name;
			
			$personInfo1 = \DB::table("document_category")
                    ->where("parent_id",$row->id)
                    ->get();
					
			foreach($personInfo1 as $row1)
			{
				$personInfoData[$row1->id] = "&nbsp;&nbsp;&nbsp;".$row1->name;
			}
		
		}
        return response()->json($personInfoData);
    }

    public function store()
    {
    	$this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitDocumentCategoryStore();

        $lenders = $this->crud->getRequest()->lenders;
        //$lender_id = end($lenders);
		
		$sms_status = config('general.sms_status');
					
		if($sms_status)
		{
			if($lenders)
			{
				foreach ($lenders as $len) {
					$lender_id = $len;
					$lenderData = \DB::table('lenders')->where('id', $lender_id)->first();
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
        
        // dd($lenders);

		return $result;
    }

    public function update()
    {
    	$this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitDocumentCategoryUpdate();

        $lenders = $this->crud->getRequest()->lenders;
        //$lender_id = end($lenders);
		
		$sms_status = config('general.sms_status');
					
		if($sms_status)
		{
			if($lenders)
			{
				foreach ($lenders as $len) {
					$lender_id = $len;
					$lenderData = \DB::table('lenders')->where('id', $lender_id)->first();
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
		// dd($lenders);

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
