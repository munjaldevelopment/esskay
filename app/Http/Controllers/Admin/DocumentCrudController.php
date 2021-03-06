<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Http\Requests\DocumentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitDocumentStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitDocumentUpdate; }
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
        CRUD::setModel(\App\Models\Document::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document');
        CRUD::setEntityNameStrings('document', 'documents');
		
		$list_document = backpack_user()->hasPermissionTo('list_document');
		if($list_document)
		{
			$this->crud->allowAccess('show');
			$this->crud->enableExportButtons();
			
			//$this->crud->denyAccess(['delete']);
			
			$maker_document = backpack_user()->hasPermissionTo('maker_document');
			if($maker_document)
			{
				//$this->crud->addClause('whereIn', 'document_status', [0,1]);
				$this->crud->allowAccess(['create', 'update']);
			}
			else
			{
				$this->crud->denyAccess(['create', 'update', 'delete']);
			}
			
			$checker_document = backpack_user()->hasPermissionTo('checker_document');
			if($checker_document)
			{
				$is_admin = backpack_user()->hasRole('Super Admin');
                if($is_admin)
                {
                    //$this->crud->addClause('where', 'document_status', '=', "0");
                    $this->crud->allowAccess(['checker_document', 'revise', 'delete']);
                }
                else
                {
                    $this->crud->denyAccess(['revise']);
                    $this->crud->allowAccess(['checker_document']);
                }
			}
			else
			{
				$this->crud->denyAccess(['checker_document', 'revise', 'delete']);
			}
			
			if($checker_document && !$maker_document)
			{
				//$this->crud->addClause('where', 'document_status', '=', "0");
			}

			$this->crud->addColumn([
                    'label'     => 'Created',
                    'type'      => 'select',
                    'name'      => 'user_id',
                    'entity'    => 'user', //function name
                    'attribute' => 'name', //name of fields in models table like districts
                    'model'     => "App\User", //name of Models

                    ]);
			
			$this->crud->addColumn([
					'label'     => 'Doc Category',
					'type'      => 'select',
					'name'      => 'document_category_id',
					'entity'    => 'documentCategory', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\DocumentCategory", //name of Models

					]);
					
			$this->crud->addColumn([
					'label'     => 'Doc Sub Category',
					'type'      => 'select',
					'name'      => 'document_sub_category_id',
					'entity'    => 'documentSubCategory', //function name
					'attribute' => 'name', //name of fields in models table like districts
					'model'     => "App\Models\DocumentCategory", //name of Models

					]);
					
			$this->crud->addColumn([
									'name' => 'document_name',
									'label' => 'Doc Name',
									'type' => 'text',
								]);
								
			$this->crud->addColumn([
									'name' => 'document_date',
									'label' => 'Year',
									'type' => 'text',
								]);

			$this->crud->addColumn([
                                    'name' => 'document_filename',
                                    'label' => 'New Document',
                                    'type' => 'browse',
                                    'limit' => '200'
                                ]);

            $this->crud->addColumn([
                                    'name' => 'document_previous',
                                    'label' => 'Old Document',
                                    'type' => 'browse_previous',
                                    'table' => 'document_revisions',
                                    'table_field' => 'document_id',
                                    'field_show' => 'document_filename',
                                    'limit' => '200'
                                ]);

            $this->crud->addColumn([
									'name' => 'expiry_date',
									'label' => 'Publish Date',
									'type' => 'date'
								]);
								
			$document_category = array();
			
			$document_category[0] = 'Select';
			$parent = \DB::table('document_category')->whereNull('parent_id')->orderBy('lft')->get();
			if($parent)
			{
				foreach($parent as $row)
				{
					$document_category[$row->id] = $row->name;
				}
			}
			//echo '<pre>';print_r($document_category); exit;
			
			$this->crud->addField([
					'label'     => 'Doc Category',
					'type'      => 'select2_from_array',
					'name'      => 'document_category_id',
					'options'   => $document_category,
					'attributes'   => [
						'id' => 'document_category_id',
						'onchange' => 'getSubCategory(this.value);'
					],
					'tab' => 'General'
					]);
					
			$this->crud->addField([
					'label'     => 'Doc Sub Category',
					'type'      => 'select2_from_array',
					'name'      => 'document_sub_category_id',
					'options'   => array(),
					'attributes'   => [
						'id' => 'document_sub_category_id'
					],
					'tab' => 'General'
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
					
			/*
					
					$child = \DB::table('document_category')->where('parent_id', $row->id)->orderBy('lft')->get();
					if($child)
					{
						foreach($child as $row1)
						{
							$document_category[$row1->id] = " >> ".$row1->name;
						}
					}*/
					
			$this->crud->addField([
									'name' => 'document_heading',
									'label' => 'Document Heading',
									'type' => 'text',
									'tab' => 'General'
								]);
					
			$this->crud->addField([
									'name' => 'document_name',
									'label' => 'Name',
									'type' => 'text',
									'tab' => 'General'
								]);
			
			$this->crud->addField([
									'name' => 'document_guide',
									'label' => 'Document Guide',
									'type' => 'text',
									'tab' => 'General'
								]);
								
			$this->crud->addField([
									'name' => 'document_status',
									'label' => 'Document Status',
									'type' => 'select2_from_array',
									'options' => ['0' => 'Inactive'],
									'tab' => 'General'
								]);
			

			$document_type = array('' => 'Select', 'audio/aac' => 'AAC audio', 'application/x-abiword' => 'AbiWord document', 'application/x-freearc' => 'Archive document', 'video/x-msvideo' => 'AVI: Audio Video Interleave', 'application/vnd.amazon.ebook' => 'Amazon Kindle eBook format', 'application/octet-stream' => 'Any kind of binary data', 'image/bmp' => 'Windows OS/2 Bitmap Graphics', 'application/x-bzip' => 'BZip archive', 'application/x-bzip2' => 'BZip2 archive', 'application/x-csh' => 'C-Shell script', 'text/css' => 'Cascading Style Sheets', 'text/csv' => 'Comma-separated values', 'application/msword' => 'Microsoft Word', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Microsoft Word (OpenXML)', 'application/vnd.ms-fontobject' => 'MS Embedded OpenType fonts', 'application/epub+zip' => 'Electronic publication (EPUB)', 'application/gzip' => 'GZip Compressed Archive', 'image/gif' => 'Graphics Interchange Format (GIF)', 'text/html' => 'HyperText Markup Language (HTML)', 'image/vnd.microsoft.icon' => 'Icon format', 'text/calendar' => 'iCalendar format', 'application/java-archive' => 'Java Archive (JAR)', 'image/jpeg' => 'JPEG images', 'application/json' => 'JSON format', 'application/ld+json' => 'JSON-LD format', 'audio/midi' => 'Musical Instrument Digital Interface (MIDI)', 'text/javascript' => 'JavaScript module', 'audio/mpeg' => 'MPEG Video', 'video/mpeg' => 'MPEG Video', 'application/vnd.apple.installer+xml' => 'Apple Installer Package', 'application/vnd.oasis.opendocument.presentation' => 'OpenDocument presentation document', 'application/vnd.oasis.opendocument.spreadsheet' => 'OpenDocument spreadsheet document', 'application/vnd.oasis.opendocument.text' => 'OpenDocument text document', 'audio/ogg' => 'OGG audio', 'video/ogg' => 'OGG video', 'application/ogg' => 'OGG', 'audio/opus' => 'Opus audio', 'font/otf' => 'OpenType font', 'image/png' => 'Portable Network Graphics', 'application/pdf' => 'Adobe Portable Document Format (PDF)', 'application/x-httpd-php' => 'Hypertext Preprocessor (Personal Home Page)', 'application/vnd.ms-powerpoint' => 'Microsoft PowerPoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'Microsoft PowerPoint (OpenXML)', 'application/vnd.rar' => 'RAR archive', 'application/rtf' => 'Rich Text Format (RTF)', 'application/x-sh' => 'Bourne shell script', 'image/svg+xml' => 'Scalable Vector Graphics (SVG)', 'application/x-shockwave-flash' => 'Small web format (SWF) or Adobe Flash document', 'application/x-tar' => 'Tape Archive (TAR)', 'image/tiff' => 'Tagged Image File Format (TIFF)', 'video/mp2t' => 'MPEG transport stream', 'font/ttf' => 'TrueType Font', 'text/plain' => 'Text', 'application/vnd.visio' => 'Microsoft Visio', 'audio/wav' => 'Waveform Audio Format', 'audio/webm' => 'WEBM audio', 'video/webm' => 'WEBM video', 'image/webp' => 'WEBP image', 'font/woff' => 'Web Open Font Format (WOFF)', 'font/woff2' => 'Web Open Font Format (WOFF)', 'application/xhtml+xml' => 'XHTML', 'application/vnd.ms-excel' => 'Microsoft Excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Microsoft Excel (OpenXML)', 'application/xml' => 'XML', 'application/vnd.mozilla.xul+xml' => 'XUL', 'application/zip' => 'ZIP archive', 'video/3gpp' => '3GPP audio/video container', 'video/3gpp2' => '3GPP2 audio/video container', 'application/x-7z-compressed' => '7-zip archive');
								
			
								
			$this->crud->addField([
									'name' => 'document_filename',
									'label' => 'File Name',
									'type' => 'browse',
									'tab' => 'General'
								]);
								
			$document_date = array('' => 'Select');
			for($count=date('Y');$count>=2015;$count--)
			{
				$document_date[$count] = $count;
			}
			
								
			$this->crud->addField([
									'name' => 'document_date',
									'label' => 'Year',
									'type' => 'select2_from_array',
									'options' => $document_date,
									'tab' => 'General'
								]);
								
			$this->crud->addField([
									'name' => 'expiry_date',
									'label' => 'Publish Date',
									'type' => 'date',
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
								
			//$this->crud->enableAjaxTable();
			
			$this->crud->addFilter([
				  'type' => 'select2',
				  'name' => 'document_category_id',
				  'label'=> 'Doc Category'
				],
				$document_category,
				function($value) {
					$this->crud->addClause('where', 'document_category_id', '=', $value);
			});

			$this->crud->addFilter([
				  'type' => 'text',
				  'name' => 'document_name',
				  'label'=> 'Name'
				],
				false,
				function($value) {
					$this->crud->addClause('where', 'document_name', 'LIKE', "%$value%");
			});
			
			$this->crud->addButtonFromView('line', 'checker_document', 'checker_document', 'end');
			
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
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DocumentRequest::class);

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

        $result = $this->traitDocumentStore();

        $lenders = $this->crud->getRequest()->lenders;
        //dd($this->crud->getRequest());
        $document_id =  $this->crud->entry->id;
        $document_heading = $this->crud->getRequest()->document_heading;
        $document_name = $this->crud->getRequest()->document_name;
        $document_guide = $this->crud->getRequest()->document_guide;
        $document_filename = $this->crud->getRequest()->document_filename;
        $document_date = $this->crud->getRequest()->document_date;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $document_status = $this->crud->getRequest()->document_status;


        \DB::table('document_revisions')->insert(['document_id' => $document_id, 'document_heading' => $document_heading, 'document_name' => $document_name,'document_guide' => $document_guide, 'document_filename' => $document_filename, 'document_date' => $document_date, 'expiry_date' => $expiry_date, 'document_status' => $document_status]);
		
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
       

		return $result;
    }

    public function update()
    {
      $this->crud->setRequest($this->crud->validateRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $result = $this->traitDocumentUpdate();

        $lenders = $this->crud->getRequest()->lenders;
        //$lender_id = end($lenders);
		
		$document_id =  $this->crud->getRequest()->id;
        $document_heading = $this->crud->getRequest()->document_heading;
        $document_name = $this->crud->getRequest()->document_name;
        $document_guide = $this->crud->getRequest()->document_guide;
        $document_filename = $this->crud->getRequest()->document_filename;
        $document_date = $this->crud->getRequest()->document_date;
        $expiry_date = $this->crud->getRequest()->expiry_date;
        $document_status = $this->crud->getRequest()->document_status;
        


        \DB::table('document_revisions')->insert(['document_id' => $document_id, 'document_heading' => $document_heading, 'document_name' => $document_name,'document_guide' => $document_guide, 'document_filename' => $document_filename, 'document_date' => $document_date, 'expiry_date' => $expiry_date, 'document_status' => $document_status]);

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
		$updateData = array('document_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('documents')->where(['id' => $document_id])->update($updateData);
		
		\DB::table('document_revisions')->where(['document_id' => $document_id])->update($updateData);
	}

	public function checkerDocumentReject($document_id)
	{
		$updateData = array('document_status' => '2', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('documents')->where(['id' => $document_id])->update($updateData);
		
		\DB::table('document_revisions')->where(['document_id' => $document_id])->update($updateData);
	}

	public function checkerTransactionDocument($document_id)
	{
		$updateData = array('document_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('transaction_documents')->where(['id' => $document_id])->update($updateData);
		
		\DB::table('transaction_document_revisions')->where(['document_id' => $document_id])->update($updateData);
	}

	public function checkerTransactionDocumentReject($document_id)
	{
		$updateData = array('document_status' => '2', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('transaction_documents')->where(['id' => $document_id])->update($updateData);
		
		\DB::table('transaction_document_revisions')->where(['document_id' => $document_id])->update($updateData);
	}

	public function checkerTransaction($document_id)
	{
		$updateData = array('transaction_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('transactions')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerTransactionReject($document_id)
	{
		$updateData = array('transaction_status' => '2', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('transactions')->where(['id' => $document_id])->update($updateData);
	}

	//'is_approve1', 'approve1_user', 'is_approve2', 'approve2_user', 'is_approve3', 'approve3_user', 
	public function checkerSanctionLetter($sanction_letter_id)
	{
		$updateData = array('is_approve1' => '1', 'approve1_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been approved by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
	}

	public function checkerSanctionLetterReject($sanction_letter_id)
	{
		$updateData = array('is_approve1' => '2', 'approve1_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been rejected by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
	}

	public function checkerSanctionLetter2($sanction_letter_id)
	{
		$updateData = array('is_approve2' => '1', 'approve2_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been approved by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
	}

	public function checkerSanctionLetterReject2($sanction_letter_id)
	{
		$updateData = array('is_approve2' => '2', 'approve2_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been rejected by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }

	}

	public function checkerSanctionLetter3($sanction_letter_id)
	{
		$updateData = array('is_approve3' => '1', 'approve3_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been approved by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
	}

	public function checkerSanctionLetterReject3($sanction_letter_id)
	{
		$updateData = array('is_approve3' => '2', 'approve3_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->update($updateData);
		
		$updateData = array('sanction_letter_status' => '1', 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('sanction_letter_revisions')->where(['sanction_letter_id' => $sanction_letter_id])->update($updateData);

		$sanctionData = \DB::table('sanction_letters')->where(['id' => $sanction_letter_id])->first();

		$sms_status = config('general.sms_status');
                
        if($sms_status)
        {
            $message = str_replace(" ", "%20", "Dear Sir, The new sanction letter approval of ".$sanctionData->facility_amount." from ".$sanctionData->bank_name." has been rejected by ".backpack_user()->name.". Kindly click on below link for the details ".backpack_url('sanction_letter/'.$sanction_letter_id."/show")." %0a ESS KAY FINCORP LIMITED.");
            $lender_phone = "9462045321";

            $request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$lender_phone."&message=".$message."&sender=EssKay&route=4&country=0";
            $smsresult = $this->getContent($request_url);
            if($smsresult['errno'] == 0){
                \DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $lender_phone, 'send_subject' => 'Document Category Added', 'send_message' => $message, 'is_deliver' => '1']);
            }
        }
	}

	// Insight
	public function checkerOperationalHighlight($document_id)
	{
		$updateData = array('operational_highlight_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('operational_highlights')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerOperationalHighlightReject($document_id)
	{
		$updateData = array('operational_highlight_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('operational_highlights')->where(['id' => $document_id])->update($updateData);
	}

	// geographicalConcentration
	public function checkergeographicalConcentration($document_id)
	{
		$updateData = array('geographical_concentration_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('geographical_concentrations')->where(['id' => $document_id])->update($updateData);
	}

	public function checkergeographicalConcentrationReject($document_id)
	{
		$updateData = array('geographical_concentration_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('geographical_concentrations')->where(['id' => $document_id])->update($updateData);
	}

	// Product Concentrations
	public function checkerproductConcentration($document_id)
	{
		$updateData = array('product_concentration_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('product_concentrations')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerproductConcentrationReject($document_id)
	{
		$updateData = array('product_concentration_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('product_concentrations')->where(['id' => $document_id])->update($updateData);
	}

	// asset_quality
	public function checkerassetQuality($document_id)
	{
		$updateData = array('asset_quality_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('asset_quality')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerassetQualityReject($document_id)
	{
		$updateData = array('asset_quality_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('asset_quality')->where(['id' => $document_id])->update($updateData);
	}

	// collection_efficiency
	public function checkercollectionEfficiency($document_id)
	{
		$updateData = array('collection_efficiency_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('collection_efficiency')->where(['id' => $document_id])->update($updateData);
	}

	public function checkercollectionEfficiencyReject($document_id)
	{
		$updateData = array('collection_efficiency_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('collection_efficiency')->where(['id' => $document_id])->update($updateData);
	}

	// net_worth
	public function checkernetWorth($document_id)
	{
		$updateData = array('net_worth_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('net_worth')->where(['id' => $document_id])->update($updateData);
	}

	public function checkernetWorthReject($document_id)
	{
		$updateData = array('net_worth_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('net_worth')->where(['id' => $document_id])->update($updateData);
	}

	// net_worth_infusion
	public function checkernetWorthInfusion($document_id)
	{
		$updateData = array('net_worth_infusion_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('net_worth_infusions')->where(['id' => $document_id])->update($updateData);
	}

	public function checkernetWorthInfusionReject($document_id)
	{
		$updateData = array('net_worth_infusion_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('net_worth_infusions')->where(['id' => $document_id])->update($updateData);
	}

	// liquidity_status
	public function checkerLiquidity($document_id)
	{
		$updateData = array('liquidity_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liquidity')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerLiquidityReject($document_id)
	{
		$updateData = array('liquidity_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liquidity')->where(['id' => $document_id])->update($updateData);
	}

	// strong_liability
	public function checkerstrongLiabilityProfile($document_id)
	{
		$updateData = array('strong_liability_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profiles')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileReject($document_id)
	{
		$updateData = array('strong_liability_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profiles')->where(['id' => $document_id])->update($updateData);
	}

	// strong_liability_table
	public function checkerstrongLiabilityProfileTable($document_id)
	{
		$updateData = array('strong_liability_table_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_tables')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileTableReject($document_id)
	{
		$updateData = array('strong_liability_table_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_tables')->where(['id' => $document_id])->update($updateData);
	}

	// strong_liability_profile_ratio
	public function checkerstrongLiabilityProfileRatio($document_id)
	{
		$updateData = array('strong_liability_ratio_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_ratio')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileRatioReject($document_id)
	{
		$updateData = array('strong_liability_ratio_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_ratio')->where(['id' => $document_id])->update($updateData);
	}
	// strong_liability_profile_driving
	public function checkerstrongLiabilityProfileDriving($document_id)
	{
		$updateData = array('strong_liability_driving_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_driving')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileDrivingReject($document_id)
	{
		$updateData = array('strong_liability_driving_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_driving')->where(['id' => $document_id])->update($updateData);
	}

	// strong_liability_profile_well_table
	public function checkerstrongLiabilityProfileWellTable($document_id)
	{
		$updateData = array('strong_liability_well_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_well_table')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileWellTableReject($document_id)
	{
		$updateData = array('strong_liability_well_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_well_table')->where(['id' => $document_id])->update($updateData);
	}
	// strong_liability_profile_overall
	public function checkerstrongLiabilityProfileOverall($document_id)
	{
		$updateData = array('strong_liability_overall_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_overall')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerstrongLiabilityProfileOverallReject($document_id)
	{
		$updateData = array('strong_liability_overall_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('strong_liability_profile_overall')->where(['id' => $document_id])->update($updateData);
	}

	// liability_profile_category
	public function checkerliabilityProfileCategory($document_id)
	{
		$updateData = array('status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liability_profile_categories')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerliabilityProfileCategoryReject($document_id)
	{
		$updateData = array('status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liability_profile_categories')->where(['id' => $document_id])->update($updateData);
	}

	// liability_profile_slider
	public function checkerliabilityProfileSlider($document_id)
	{
		$updateData = array('status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liability_profile_slider')->where(['id' => $document_id])->update($updateData);
	}

	public function checkerliabilityProfileSliderReject($document_id)
	{
		$updateData = array('status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('liability_profile_slider')->where(['id' => $document_id])->update($updateData);
	}

	// checker_covid_relief_lender
	public function checkercovidReliefLender($document_id)
	{
		$updateData = array('covid_relief_lender_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('covid_relief_lenders')->where(['id' => $document_id])->update($updateData);
	}

	public function checkercovidReliefLenderReject($document_id)
	{
		$updateData = array('covid_relief_lender_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('covid_relief_lenders')->where(['id' => $document_id])->update($updateData);
	}

	// checker_covid_relief_lender
	public function checkercovidReliefBorrower($document_id)
	{
		$updateData = array('covid_relief_borrower_status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('covid_relief_borrowers')->where(['id' => $document_id])->update($updateData);
	}

	public function checkercovidReliefBorrowerReject($document_id)
	{
		$updateData = array('covid_relief_borrower_status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('covid_relief_borrowers')->where(['id' => $document_id])->update($updateData);
	}

	// current_deal_category
	public function checkercurrentDealCategory($document_id)
	{
		$updateData = array('status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('current_deal_categories')->where(['id' => $document_id])->update($updateData);
	}

	public function checkercurrentDealCategoryReject($document_id)
	{
		$updateData = array('status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('current_deal_categories')->where(['id' => $document_id])->update($updateData);
	}

	// current_deal
	public function checkercurrentDeal($document_id)
	{
		$updateData = array('status' => '1', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('current_deals')->where(['id' => $document_id])->update($updateData);
	}

	public function checkercurrentDealReject($document_id)
	{
		$updateData = array('status' => '2', 'approve_user' => backpack_user()->id, 'updated_at' => date('Y-m-d H:i:s'));
		\DB::table('current_deals')->where(['id' => $document_id])->update($updateData);
	}
}