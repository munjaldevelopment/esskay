<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Mail;
use Input;
use Redirect;
use Session;
use Validator;
use App\User;
use App\Models\Page;
use App\Models\Setting;
use App\Models\AnalyticsGraph;
use App\Models\AnalyticsGraphDetail;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
	public function showStatus()
	{
		echo config('general.sms_status');
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
	
	public function postContent($request_url, $data) 
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $request_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return $err;
		} else {
			return $response;
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $request_url,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 500,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		
	}
	
	// Home
	public function index()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(1);
		$pageData = json_decode($pageInfo['extras']);
		//dd($pageData);
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			$parentData = \DB::table('document_category')->whereNull('parent_id')->orderBy('lft', 'ASC')->get();
		
			$parentCategoryData = $childCategoryData = array();
			
			if($parentData)
			{
				foreach($parentData as $parentRow)
				{
					$parentCategoryData[$parentRow->id] = $parentRow->name;
					
					$childData = \DB::table('document_category')->where('parent_id', $parentRow->id)->orderBy('lft', 'ASC')->get();
					
					if($childData)
					{
						foreach($childData as $childRow)
						{
							$childCategoryData[$parentRow->id][$childRow->id] = $childRow->name;
						}
					}
				}
			}
			
			$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
			
			$lenderCode = substr($lenderData->code, 0, 1);
			//dd($lenderData);

			// Lender Banking Assessment
			$bankingData = \DB::table('lender_banking')->leftJoin('banking_arrangment', 'lender_banking.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->get();

			$lenderBankingData = array();
			foreach ($bankingData as $bdata) {
				# code...
				if($bdata->lender_banking_status == 1 && ($bdata->sanction_amount > 0.00 || $bdata->outstanding_amount > 0.00)) {
					$lenderBankingData[] = array('lender_id' => $bdata->lender_id,'banking_arrangment_id' => $bdata->banking_arrangment_id,'banking_arrangment_name' => $bdata->name,'sanction_amount' => $bdata->sanction_amount,'outstanding_amount' => $bdata->outstanding_amount);
				}else{
					$bankingData_r = \DB::table('lender_banking_revisions')->leftJoin('banking_arrangment', 'lender_banking_revisions.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->where('banking_arrangment_id', $bdata->banking_arrangment_id)->where('lender_banking_revisions.lender_banking_status', '1')->orderby('lender_banking_revisions.id','DESC')->first();
					if($bankingData_r){
						$lenderBankingData[] = array('lender_id' => $bankingData_r->lender_id,'banking_arrangment_id' => $bankingData_r->banking_arrangment_id,'banking_arrangment_name' => $bankingData_r->name,'sanction_amount' => $bankingData_r->sanction_amount,'outstanding_amount' => $bankingData_r->outstanding_amount);
					}
				}
			}
			
			//echo '<pre>'; print_r($lenderBankingData); exit;
			return view('ess-kay-home', ['customer_name' => $customer_name, 'parentCategoryData' => $parentCategoryData, 'childCategoryData' => $childCategoryData, 'lenderData' => $lenderData, 'lenderCode' => $lenderCode, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'lenderBankingData' => $lenderBankingData, 'lenderCount' => count($lenderBankingData)]);
		}
	}
	
	// Login
	public function termCondition()
    {
		Setting::assignSetting();

		$termsInfo = Page::getPageInfo(8);
		$disclaimerInfo = Page::getPageInfo(9);

		return view('term-condition', ['title' => $termsInfo->meta_title, 'meta_description' => $termsInfo->meta_description, 'meta_keywords' => $termsInfo->meta_keywords, 'termsTitle' => $termsInfo->title, 'termsContent' => $termsInfo->content, 'disclaimerTitle' => $disclaimerInfo->title,'disclaimerContent' => $disclaimerInfo->content]);
	}

	public function disclaimer()
    {
		Setting::assignSetting();

		$termsInfo = Page::getPageInfo(8);
		$disclaimerInfo = Page::getPageInfo(9);

		return view('disclaimer', ['title' => $disclaimerInfo->meta_title, 'meta_description' => $disclaimerInfo->meta_description, 'meta_keywords' => $disclaimerInfo->meta_keywords, 'termsTitle' => $termsInfo->title, 'termsContent' => $termsInfo->content, 'disclaimerTitle' => $disclaimerInfo->title,'disclaimerContent' => $disclaimerInfo->content]);
	}

	public function login()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$riders = array();
			$termsInfo = Page::getPageInfo(8);
			$disclaimerInfo = Page::getPageInfo(9);
			
			return view('login', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'termsTitle' => $termsInfo->title, 'termsContent' => $termsInfo->content, 'disclaimerTitle' => $disclaimerInfo->title,'disclaimerContent' => $disclaimerInfo->content]);
		}
	}

	// Login
	public function loginOtp()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$riders = array();
			return view('login-otp', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
	}

	public function saveLoginOTP(Request $request)
    {
		// TO DO
		// TO DO
		$messages = [
			'agree.required' => 'You must agree to the Terms and Conditions',
		];
		$rules = array (
			'phone' => 'required',
			'agree' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules, $messages );
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator, 'login' )->withInput ();
		}
		else
		{
			$checkRecord = \DB::table('users')->where(['phone' => $request->phone, 'user_status' => '1'])->first();
				
			if($checkRecord)
			{
				$user_id = $checkRecord->id;
				
				$user = User::findOrFail($user_id);
				if($user) {
					// Find User ID
					backpack_auth()->login($user);
					
					$sms_status = config('general.sms_status');
					
					if($sms_status)
					{
						$message = str_replace(" ", "%20", "Dear ".$user->name.", please use this OTP ".$user->user_otp." to login");
						
						$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$user->phone."&message=".$message."&sender=EssKay&route=4&country=0";
						$result = $this->getContent($request_url);
						
						
						if($result['errno'] == 0)
						{
							\DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $user->phone, 'send_subject' => 'User OTP', 'send_message' => $message, 'is_deliver' => '1']);
						} else {
							Session::flash ( 'message', "Error in sending message. Please re-try" );
							return Redirect::back ();
						}
					}
						
					session ( [
						'esskay_name' => $checkRecord->email,
						'esskay_user_id' => $user_id
					] );
					
					$agent = new Agent();
					$browser = $agent->browser();
					$version = $agent->version($browser);
					
					$desktop = $agent->isDesktop();
					$mobile = $agent->isMobile();
					$tablet = $agent->isTablet();
					
					$device_type = "";
					if($desktop == 1)
					{
						$device_type = "Desktop";
					}
					else if($mobile == 1)
					{
						$device_type = "Mobile";
					}
					else if($tablet == 1)
					{
						$device_type = "Tablet";
					}
					
					\DB::table('user_login')->insert(['user_id' => $user_id, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'phone', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					
					return redirect(url('/user_otp'));					
				} else {
					Session::flash ( 'message', "Invalid Credentials, Please try again." );
					return Redirect::back ();
				}
			} else {
				Session::flash ( 'message', "Phone Number not exists or not activated yet. Please try again." );
				return Redirect::back ();
			}
		}
	}
	
	public function logout(Request $request)
    {
		session()->forget('esskay_name');
		session()->forget('esskay_user_id');
		session()->forget('esskay_verify');
		
		return redirect(url('/').'/');
	}
	
	// Login
	public function userOTP()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_name');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			$checkRecord = \DB::table('users')->where(['email' => $customer_name])->first();
			
			$user_otp = $checkRecord->user_otp;
			return view('user_otp', ['customer_name' => $customer_name, 'user_otp' => $user_otp, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
			
		}
		else
		{
			return redirect(url('/login'));
		}
	}
	
	public function saveContact(Request $request)
    {
		\DB::table('contact_us')->insert(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'telephone' => $request->telephone, 'message' => $request->message]);
		
		\DB::table('email_sms')->insert(['send_type' => 'email', 'send_to' => $request->email, 'send_subject' => 'Contact Us', 'send_message' => $request->message, 'is_deliver' => '1']);
		
		$contactData = array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'telephone' => $request->telephone, 'user_message' => $request->message);
		$tempUserData = array('email' => $request->email, 'name' => $request->first_name." ".$request->last_name);
		
		Mail::send('emails.contact_us', $contactData, function ($message) use ($tempUserData) {
			$message->to($tempUserData['email'], $tempUserData['name'])->subject("Contact Us");
			$message->from('communication@skfin.in', 'Ess Kay Fincorp');
		});
		
		echo "Thanks for your contact. Our team will get back to you within 24-48 hours";
	}
	
	public function browserInfo(Request $request)
    {
		$browserDetails = $request->header('User-Agent');
		dd($browserDetails);
	}
	
	public function changeQuery()
    {
		\DB::statement("ALTER TABLE `document_category` ADD `category_icon` VARCHAR(100) NULL DEFAULT NULL AFTER `is_timeline`");
		\DB::statement("ALTER TABLE `document_category` ADD `category_content_type` VARCHAR(100) NULL DEFAULT NULL AFTER `category_icon`");
		
		/*\DB::statement("UPDATE lenders SET created_at = '2020-12-07 19:42:01' WHERE id > 1 AND id < 10");
		\DB::statement("UPDATE lenders SET created_at = '2020-11-30 19:42:01' WHERE id > 10 AND id <= 25");
		\DB::statement("UPDATE lenders SET created_at = '2020-10-15 19:42:01' WHERE id > 25 AND id <= 45");
		\DB::statement("UPDATE lenders SET created_at = '2020-09-30 19:42:01' WHERE id > 45");*/
	}
	
	public function chart()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$chart1 = \Chart::title([
			'text' => 'Voting ballon d`or 2018',
		])
		->chart([
			'type'     => 'column', // pie , columnt ect
			'renderTo' => 'first_chart', // render the chart into your div with id
		])
		->subtitle([
			'text' => '',
		])
		->colors([
			'#0c2959'
		])
		->xaxis([
			'categories' => [
				'Alex Turner',
				'Julian Casablancas',
				'Bambang Pamungkas',
				'Mbah Surip',
			],
			'labels'     => [
				'rotation'  => 15,
				'align'     => 'top',
				// use 'startJs:yourjavasscripthere:endJs'
			],
		])
		->legend([
			'layout'        => 'vertical',
			'align'         => 'right',
			'verticalAlign' => 'middle',
		])
		->credits([
			'enabled' => 'false'
		])
		->series(
			[
				[
					'name'  => 'Voting',
					'data'  => [43934, 52503, 57177, 69658],
					// 'color' => '#0c2959',
				],
			]
		)
		->display();
		
		//echo '<div id=first_chart"></div><br />'.$chart1; exit;

		return view('chart', [
			'title' => 'Chart',
			'meta_keywords' => 'Chart',
			'meta_description' => 'Chart',
			'customer_name' => $customer_name,
			'chart1' => $chart1
		]);
	}
	
	public function sendMail()
    {
		$contactData = array('first_name' => 'Munjal', 'last_name' => 'Mayank', 'email' => 'munjalmayank@gmail.com', 'telephone' => '9462045321', 'user_message' => 'My Message');
		$tempUserData = array('email' => 'munjalmayank@gmail.com', 'name' => 'Munjal Mayank');
		
		Mail::send('emails.contact_us', $contactData, function ($message) use ($tempUserData) {
			$message->to($tempUserData['email'], $tempUserData['name'])->subject("Contact Us");
			$message->from('communication@skfin.in', 'Ess Kay Fincorp');
		});
		
		echo "Thanks for your contact. Our team will get back to you within 24-48 hours";
	}
	
	public function downloadDoc($doc_id)
    {	// Download file
		$doc_id = base64_decode($doc_id);
		$docData  = \DB::table('documents')->where('id', '=', $doc_id)->first();
		
		if($docData)
		{
			$file= public_path(). "/".$docData->document_filename;
			
			/*$headers = array(
					  'Content-Type: application/pdf',
					);*/
					
			$document_filename = explode("/", $docData->document_filename);
			$doc = array_pop($document_filename);

			\DB::table('user_document')->insert(['user_id' => session()->get('esskay_user_id'), 'document_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			
			return response()->download($file, $doc);
		}
	}

	public function previewDoc($doc_id)
    {	
    	// Download file
		$doc_id = base64_decode($doc_id);
		$docData  = \DB::table('documents')->where('id', '=', $doc_id)->first();
		
		if($docData)
		{
			$file = asset('/'). $docData->document_filename;

			header('location:'.$file);
		}
	}
	
	public function downloadFile($doc_id)
    {	// Download file
		$docData  = \DB::table('articles')->where('id', '=', $doc_id)->first();
		
		$file= public_path(). "/".$docData->article_pdf;
		
		/*$headers = array(
				  'Content-Type: application/pdf',
				);*/
				
		$article_pdf = explode("/", $docData->article_pdf);
		$doc = array_pop($article_pdf);

		\DB::table('user_pdf')->insert(['user_id' => session()->get('esskay_user_id'), 'article_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		
		return response()->download($file, $doc);
	}
	
	
	public function showChildDoc(Request $request)
    {
		//dd($request->all());
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;
		
		$parentData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();
		$is_timeline = 0;
		if($parentData)
		{
			$is_timeline = $parentData->is_timeline;
		}
		
		//echo $request->document_date;
		
		if($is_timeline)
		{
			$docData = \DB::table('documents')->leftJoin('document_lender', 'documents.id', '=', 'document_lender.document_id')->where('document_lender.lender_id',$lender_id)->where('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_lender.document_id')->get();
		}
		else
		{
			$docData = \DB::table('documents')->leftJoin('document_lender', 'documents.id', '=', 'document_lender.document_id')->where('document_lender.lender_id',$lender_id)->where('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_lender.document_id')->get();
		}
		
		//dd($docData);
		
		$docArr = array();
		foreach($docData as $doc)
		{
			if($is_timeline)
			{
				if($doc->document_date == $request->document_date)
				{
					if($doc->document_status == 1){
						$ext = pathinfo($doc->document_filename, PATHINFO_EXTENSION);
						$ext = strtolower($ext);
						if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
						{
							$ext = "picture";
						}
						else if($ext == "xls" || $ext == "xlsx")
						{
							$ext = "excel";
						}
						else if($ext == "doc" || $ext == "docx")
						{
							$ext = "word";
						}
						
						$doc_download = \DB::table('user_document')->where('document_id', '=', $doc->id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
						$docArr[] = array('id' => $doc->id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $doc->document_heading, 'document_filename' => $doc->document_filename, 'ext' => $ext, 'document_name' => $doc->document_name, 'expiry_date' => $doc->expiry_date, 'doc_download' => $doc_download);
					}else{
						$docr = \DB::table('document_revisions')->where('document_id', '=', $doc->id)->where('document_status', 1)->orderBy('id', 'DESC')->first();


						if($docr){
							$ext = pathinfo($docr->document_filename, PATHINFO_EXTENSION);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}
							
							$doc_download = \DB::table('user_document')->where('document_id', '=', $docr->document_id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
							$docArr[] = array('id' => $docr->document_id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $docr->document_heading, 'document_filename' => $docr->document_filename, 'ext' => $ext, 'document_name' => $docr->document_name, 'expiry_date' => $docr->expiry_date, 'doc_download' => $doc_download);
						}


					}
				}
			}
			else
			{
				if($doc->document_status == 1){
					$ext = pathinfo($doc->document_filename, PATHINFO_EXTENSION);
					$ext = strtolower($ext);
					if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
					{
						$ext = "picture";
					}
					else if($ext == "xls" || $ext == "xlsx")
					{
						$ext = "excel";
					}
					else if($ext == "doc" || $ext == "docx")
					{
						$ext = "word";
					}
					
					$doc_download = \DB::table('user_document')->where('document_id', '=', $doc->id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
					$docArr[] = array('id' => $doc->id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $doc->document_heading, 'document_filename' => $doc->document_filename, 'ext' => $ext, 'document_name' => $doc->document_name, 'expiry_date' => $doc->expiry_date, 'doc_download' => $doc_download);
				}else{
					$docr = \DB::table('document_revisions')->where('document_id', '=', $doc->id)->where('document_status', 1)->orderBy('id', 'DESC')->first();


					if($docr){
						$ext = pathinfo($docr->document_filename, PATHINFO_EXTENSION);
						if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
						{
							$ext = "picture";
						}
						else if($ext == "xls" || $ext == "xlsx")
						{
							$ext = "excel";
						}
						else if($ext == "doc" || $ext == "docx")
						{
							$ext = "word";
						}
						
						$doc_download = \DB::table('user_document')->where('document_id', '=', $docr->document_id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
						$docArr[] = array('id' => $docr->document_id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $docr->document_heading, 'document_filename' => $docr->document_filename, 'ext' => $ext, 'document_name' => $docr->document_name, 'expiry_date' => $docr->expiry_date, 'doc_download' => $doc_download);
					}


				}
			}
			//
		}
		
		$document_date = array();
		for($count=date('Y');$count>=2015;$count--)
		{
			$document_date[$count] = $count;
		}
		
		$docCategoryData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();

		$category_name = $docCategoryData->name;
		
		if($docCategoryData->parent_id != null)
		{
			$docCategoryData1 = \DB::table('document_category')->where('id', '=', $docCategoryData->parent_id)->first();
			
			$docCategoryData2 = \DB::table('document_category')->where('id', '=', $docCategoryData1->parent_id)->first();
			
			$cat_name = '';
			if($docCategoryData2)
			{
				$cat_name .= '<li><a href="#">'.$docCategoryData2->name . ' </a></li> ';
			}
			
			$cat_name = '<li><a href="#">'.$docCategoryData1->name . ' </a></li><li> ' . $docCategoryData->name.'</li>';
			
			$is_timeline = $docCategoryData->is_timeline;
			
		}
		else
		{
			$cat_name = '<li>'.$docCategoryData->name.'</li>';
			
			$is_timeline = $docCategoryData->is_timeline;
		}
		
		//dd($docArr);
		$subCategoryArr = array();
		$docSubCategoryData = \DB::table('document_category')->where('parent_id', '=', $request->category_id)->get();
		if($docSubCategoryData)
		{
			foreach($docSubCategoryData as $docSubCategoryRow)
			{
				$subCategoryArr[] = array('id' => $docSubCategoryRow->id, 'name' => $docSubCategoryRow->name);
			}
		}
		
		return view('document-child-file', ['documentDateData' => $document_date, 'docu_date' => $request->document_date, 'cat_name' => $cat_name, 'category_name' => $category_name, 'subCategory' => $subCategoryArr, 'category_id' => $request->category_id, 'is_timeline' => $is_timeline, 'docData' => $docArr, 'esskay_doc_date' => session()->get('esskay_doc_date')]);
	}

	public function showDoc(Request $request)
    {
		//dd($request->all());
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;
		
		$parentData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();
		$is_timeline = 0;
		if($parentData)
		{
			$is_timeline = $parentData->is_timeline;
		}
		
		//echo $request->document_date;
		
		if($is_timeline)
		{
			$docData = \DB::table('documents')->leftJoin('document_lender', 'documents.id', '=', 'document_lender.document_id')->where('document_lender.lender_id',$lender_id)->where('documents.document_category_id', '=', $request->category_id)->orWhere('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_lender.document_id')->get();
		}
		else
		{
			$docData = \DB::table('documents')->leftJoin('document_lender', 'documents.id', '=', 'document_lender.document_id')->where('document_lender.lender_id',$lender_id)->where('documents.document_category_id', '=', $request->category_id)->orWhere('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_lender.document_id')->get();
		}
		
		//dd($docData);
		
		$docArr = array();
		foreach($docData as $doc)
		{
			if($is_timeline)
			{
				if($doc->document_date == $request->document_date)
				{
					if($doc->document_status == 1){
						$ext = pathinfo($doc->document_filename, PATHINFO_EXTENSION);
						$ext = strtolower($ext);
						if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
						{
							$ext = "picture";
						}
						else if($ext == "xls" || $ext == "xlsx")
						{
							$ext = "excel";
						}
						else if($ext == "doc" || $ext == "docx")
						{
							$ext = "word";
						}
						
						$doc_download = \DB::table('user_document')->where('document_id', '=', $doc->id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
						$docArr[] = array('id' => $doc->id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $doc->document_heading, 'document_filename' => $doc->document_filename, 'ext' => $ext, 'document_name' => $doc->document_name, 'expiry_date' => $doc->expiry_date, 'doc_download' => $doc_download);
					}else{
						$docr = \DB::table('document_revisions')->where('document_id', '=', $doc->id)->where('document_status', 1)->orderBy('id', 'DESC')->first();


						if($docr){
							$ext = pathinfo($docr->document_filename, PATHINFO_EXTENSION);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}
							
							$doc_download = \DB::table('user_document')->where('document_id', '=', $docr->document_id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
							$docArr[] = array('id' => $docr->document_id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $docr->document_heading, 'document_filename' => $docr->document_filename, 'ext' => $ext, 'document_name' => $docr->document_name, 'expiry_date' => $docr->expiry_date, 'doc_download' => $doc_download);
						}


					}
				}
			}
			else
			{
				if($doc->document_status == 1){
					$ext = pathinfo($doc->document_filename, PATHINFO_EXTENSION);
					$ext = strtolower($ext);
					if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
					{
						$ext = "picture";
					}
					else if($ext == "xls" || $ext == "xlsx")
					{
						$ext = "excel";
					}
					else if($ext == "doc" || $ext == "docx")
					{
						$ext = "word";
					}
					
					$doc_download = \DB::table('user_document')->where('document_id', '=', $doc->id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
					$docArr[] = array('id' => $doc->id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $doc->document_heading, 'document_filename' => $doc->document_filename, 'ext' => $ext, 'document_name' => $doc->document_name, 'expiry_date' => $doc->expiry_date, 'doc_download' => $doc_download);
				}else{
					$docr = \DB::table('document_revisions')->where('document_id', '=', $doc->id)->where('document_status', 1)->orderBy('id', 'DESC')->first();


					if($docr){
						$ext = pathinfo($docr->document_filename, PATHINFO_EXTENSION);
						if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
						{
							$ext = "picture";
						}
						else if($ext == "xls" || $ext == "xlsx")
						{
							$ext = "excel";
						}
						else if($ext == "doc" || $ext == "docx")
						{
							$ext = "word";
						}
						
						$doc_download = \DB::table('user_document')->where('document_id', '=', $docr->document_id)->where('user_id', '=', session()->get('esskay_user_id'))->count();
						$docArr[] = array('id' => $docr->document_id, 'category_id' => $doc->document_category_id, 'sub_category_id' => $doc->document_sub_category_id, 'document_heading' => $docr->document_heading, 'document_filename' => $docr->document_filename, 'ext' => $ext, 'document_name' => $docr->document_name, 'expiry_date' => $docr->expiry_date, 'doc_download' => $doc_download);
					}


				}
			}
			//
		}
		
		$document_date = array();
		for($count=date('Y');$count>=2015;$count--)
		{
			$document_date[$count] = $count;
		}
		
		$docCategoryData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();
		
		if($docCategoryData->parent_id != null)
		{
			$docCategoryData1 = \DB::table('document_category')->where('id', '=', $docCategoryData->parent_id)->first();
			
			$docCategoryData2 = \DB::table('document_category')->where('id', '=', $docCategoryData1->parent_id)->first();
			
			$cat_name = '';
			if($docCategoryData2)
			{
				$cat_name .= '<li><a href="#">'.$docCategoryData2->name . ' </a></li> ';
			}
			
			$cat_name = '<li><a href="#">'.$docCategoryData1->name . ' </a></li><li> ' . $docCategoryData->name.'</li>';
			
			$is_timeline = $docCategoryData->is_timeline;
			$category_name = $docCategoryData->name;
		}
		else
		{
			$cat_name = '<li>'.$docCategoryData->name.'</li>';
			
			$is_timeline = $docCategoryData->is_timeline;
			$category_name = $docCategoryData->name;
		}
		
		//dd($docArr);
		$subCategoryArr = array();
		$docSubCategoryData = \DB::table('document_category')->where('parent_id', '=', $request->category_id)->get();
		if($docSubCategoryData)
		{
			foreach($docSubCategoryData as $docSubCategoryRow)
			{
				$subCategoryArr[] = array('id' => $docSubCategoryRow->id, 'name' => $docSubCategoryRow->name);
			}
		}
		
		$current_year = date('Y');
		return view('document-file', ['documentDateData' => $document_date, 'docu_date' => $request->document_date, 'cat_name' => $cat_name, 'category_name' => $category_name, 'subCategory' => $subCategoryArr, 'is_timeline' => $is_timeline, 'docData' => $docArr, 'esskay_doc_date' => session()->get('esskay_doc_date'), 'current_year' => $current_year]);
	}
	
	// Forget Password
	public function forgotPassword()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(6);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$riders = array();
			return view('forgot-password', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
	}
	
	public function saveForgot(Request $request)
    {
		$rules = array (
			'email' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator, 'login' )->withInput ();
		}
		else
		{
			$checkRecord = \DB::table('users')->where(['email' => $request->email, 'user_status' => '1'])->first();
				
			if($checkRecord)
			{
				$user_id = $checkRecord->id;
				
				$sms_status = config('general.sms_status');
				//echo $sms_status;
					
				if($sms_status)
				{
					$message = str_replace(" ", "%20", "Dear ".$checkRecord->name.", please use this OTP ".$checkRecord->user_otp." to reset the password");
						
					$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$checkRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
					$result = $this->getContent($request_url);
					//dd($result);
					
					if($result['errno'] == 0)
					{
						\DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $checkRecord->phone, 'send_subject' => 'User OTP', 'send_message' => $message, 'is_deliver' => '1']);
					}  else {
						Session::flash ( 'message', "Error in sending message. Please re-try" );
						return Redirect::back ();
					}
				}
				
				session ( [
					'forget_user_id' => $user_id
				] );
				
				return redirect(url('/change_password'));
			} else {
				Session::flash ( 'message', "Email not exists or not activated yet. Please try again." );
				return Redirect::back ();
			}
		}
	}

	// Forget Password Phone
	public function forgotPasswordPhone()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(6);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$riders = array();
			return view('forgot-password-phone', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
	}
	
	public function saveForgotPhone(Request $request)
    {
		$rules = array (
			'phone' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator, 'login' )->withInput ();
		}
		else
		{
			$checkRecord = \DB::table('users')->where(['phone' => $request->phone, 'user_status' => '1'])->first();
				
			if($checkRecord)
			{
				$user_id = $checkRecord->id;
				
				$sms_status = config('general.sms_status');
				//echo $sms_status;
					
				if($sms_status)
				{
					$message = str_replace(" ", "%20", "Dear ".$checkRecord->name.", please use this OTP ".$checkRecord->user_otp." to reset the password");
						
					$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$checkRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
					$result = $this->getContent($request_url);
					//dd($result);
					
					if($result['errno'] == 0)
					{
						\DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $checkRecord->phone, 'send_subject' => 'User OTP', 'send_message' => $message, 'is_deliver' => '1']);
					}  else {
						Session::flash ( 'message', "Error in sending message. Please re-try" );
						return Redirect::back ();
					}
				}
				
				session ( [
					'forget_user_id' => $user_id
				] );
				
				return redirect(url('/change_password'));
			} else {
				Session::flash ( 'message', "Phone number not exists or not activated yet. Please try again." );
				return Redirect::back ();
			}
		}
	}
	
	// Register
	public function register()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(5);

		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$riders = array();
			$termsInfo = Page::getPageInfo(8);
			$disclaimerInfo = Page::getPageInfo(9);

			return view('register', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords , 'termsTitle' => $termsInfo->title, 'termsContent' => $termsInfo->content, 'disclaimerTitle' => $disclaimerInfo->title,'disclaimerContent' => $disclaimerInfo->content]);
		}
	}
	
	public function saveRegister(Request $request)
    {
		//name, email, telephone, organization, designation, message
		$rules = array (
			'name'     => 'required',
			'email'    => 'required',
            'telephone'    => 'required',
            'organization'     => 'required',
			'message'     => 'required',
			'agree' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		if ($validator->fails ()) {
			echo "<div class='alert alert-danger'>Please fill all entries.</div>";
		}
		else
		{
			$user_id = \DB::table('enquiry')->insert(['name' => $request->name, 'email' => $request->email, 'telephone' => $request->telephone, 'organization' => $request->organization, 'designation' => $request->designation, 'message' => $request->message, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			
			echo "<div class='alert alert-success'>Thank you for showing your interest with esskay fincorp limited, our representative will get in touch with you shortly.</div>";
		}
	}
	
	// Update Password
	public function changePassword()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			return redirect(url('/'));
		}
		else
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('forget_user_id'), 'user_status' => '1'])->first();
			if($userRecord)
			{
				//dd($userRecord);
				
				$riders = array();
				return view('change-password', ['customer_name' => $customer_name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'user_otp' => $userRecord->user_otp]);
			}
			else
			{
				return redirect(url('/'));
			}
		}
	}
	
	public function saveChangePassword(Request $request)
    {
		$rules = array (
			'user_otp' => 'required',
			'password' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		if ($validator->fails ()) {
			echo "<div class='alert alert-danger'>Please correct all entries.</div>";
		}
		else
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('forget_user_id'), 'user_status' => '1'])->first();
			
			if($userRecord)
			{
				if($userRecord->user_otp == $request->user_otp)
				{
					$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
					\DB::table('users')->where(['id' => session()->get('forget_user_id')])->update($updateData);
					
					// Send SMS
					$sms_status = config('general.sms_status');
					
					if($sms_status)
					{
						$message = str_replace(" ", "%20", "Dear ".$userRecord->name.", your password has been changed successfully. In case you haven't changed the password recently, please contact us at +91-7014592698");
						
						$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$userRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
						$result = $this->getContent($request_url);
					}
					
					// Send Mail
					$contactData = array('first_name' => $userRecord->name, 'email' => $userRecord->email, 'telephone' => $userRecord->phone);
					$tempUserData = array('email' => $userRecord->email, 'name' => $userRecord->name);
					
					Mail::send('emails.change_password', $contactData, function ($message) use ($tempUserData) {
						$message->to($tempUserData['email'], $tempUserData['name'])->subject("Change Password");
						$message->cc('communication@skfin.in');
						$message->from('communication@skfin.in', 'Ess Kay Fincorp');
					});
	
					session()->forget('forget_user_id');
				
					echo 1;
				}
				else
				{
					echo "<div class='alert alert-danger'>OTP Mistamtch. Please try again.</div>";
				}
				
			} else {
				echo "<div class='alert alert-danger'>User not exists. Please try again.</div>";
			}
		}
	}
	
	public function saveLogin(Request $request)
    {
		// TO DO
		$messages = [
			'agree.required' => 'You must agree to the Terms and Conditions',
		];

		$rules = array (
			'email' => 'required',
			'password' => 'required',
			'agree' => 'required',
			'recaptcha' => 'required',
		);

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$remoteip = $_SERVER['REMOTE_ADDR'];
		$data = [
		        'secret' => config('services.recaptcha.secret'),
		        'response' => $request->get('recaptcha'),
		        'remoteip' => $remoteip
		      ];
		$options = [
		        'http' => [
		          'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		          'method' => 'POST',
		          'content' => http_build_query($data)
		        ]
		    ];
		$context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);
        //dd($resultJson);
        $validator = Validator::make ( Input::all (), $rules, $messages );
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator, 'login' )->withInput ();
		}
		else
		{
			if ($resultJson->success != true) {
				Session::flash ( 'message', "Please fill all information and try again" );
				return Redirect::back ();
				
			}
			else
			{
				if ($resultJson->score >= 0.3) {
					if($request->email != "")
					{

						$checkRecord = \DB::table('users')->where(['email' => $request->email, 'user_status' => '1'])->first();
							
						if($checkRecord)
						{
							$user_id = $checkRecord->id;
							
							//echo $request->email.",".$request->password; exit;
							$agent = new Agent();
							$browser = $agent->browser();
							$version = $agent->version($browser);
							
							$desktop = $agent->isDesktop();
							$mobile = $agent->isMobile();
							$tablet = $agent->isTablet();
							
							$device_type = "";
							if($desktop == 1)
							{
								$device_type = "Desktop";
							}
							else if($mobile == 1)
							{
								$device_type = "Mobile";
							}
							else if($tablet == 1)
							{
								$device_type = "Tablet";
							}
							if (Auth::attempt ( array (
								'email' => $request->email,
								'password' => $request->password
							) )) {
								$user = User::findOrFail($user_id);
								
								if($user) {
									// Find User ID
									
									session ( [
										'esskay_name' => $checkRecord->email,
										'esskay_user_id' => $user_id,
										'esskay_verify' => '1'
									] );
									
									$user_login_attempt = 0;
									$updateData = array('login_attempt' => $user_login_attempt, 'updated_at' => date('Y-m-d H:i:s'));
										\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
									
									\DB::table('user_login')->insert(['user_id' => $user_id, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'email', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
									
									return redirect(url('/'));
								} else {

									$user_login_attempt = $checkRecord->login_attempt+1;
									if($user_login_attempt < 4){
										$email = $request->email;
										\DB::table('user_login_attempt')->insert(['email' => $email, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'email', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
										$updateData = array('login_attempt' => $user_login_attempt, 'updated_at' => date('Y-m-d H:i:s'));
										\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
									}else{
										$user_status = 0;
										$updateData = array('user_status' => $user_status, 'updated_at' => date('Y-m-d H:i:s'));
										\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
									}
									
									Session::flash ( 'message', "Invalid Credentials, Please try again." );
									return Redirect::back ();
								}
							} else {
									
									$user_login_attempt = $checkRecord->login_attempt+1;
									if($user_login_attempt < 4){
										$email = $request->email;

										\DB::table('user_login_attempt')->insert(['email' => $email, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'email', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
										$updateData = array('login_attempt' => $user_login_attempt, 'updated_at' => date('Y-m-d H:i:s'));
										\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
									}else{
										$user_status = 0;
										$updateData = array('user_status' => $user_status, 'updated_at' => date('Y-m-d H:i:s'));
										\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
									}
								Session::flash ( 'message', "Invalid Credentials, Please try again." );
								return Redirect::back ();
							}
						} else {
							Session::flash ( 'message', "Email not exists or not activated yet. Please try again." );
							return Redirect::back ();
						}
					}
				}else{
					Session::flash ( 'message', "Please fill all information and try again" );
					return Redirect::back ();
				}
			}
		}
	}
	
	public function saveUserOTP(Request $request)
    {
		$rules = array (
			'user_otp' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator, 'login' )->withInput ();
		}
		else
		{
			$checkRecord = \DB::table('users')->where(['email' => session()->get('esskay_name')])->where(['user_otp' => $request->user_otp])->first();
			
			if($checkRecord)
			{
				$user_otp = rand(111111, 999999);
				$updateData = array('user_otp' => $user_otp, 'updated_at' => date('Y-m-d H:i:s'));
				\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
				
				session ( [
					'esskay_verify' => '1'
				] );
				
				return redirect(url('/'));
			} else {
				Session::flash ( 'message', "Invalid OTP, Please try again." );
				return Redirect::back ();
			
			}
		}
	}
	
	// AJAX CALL
	public function homepage()
    {	
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(1);
		//dd($pageInfo);
		
		$content = str_replace("INVERTEDLEFT", '<i class="fa fa-quote-left quote-icons" style=""></i>', $pageInfo->content);
		$content1 = str_replace("INVERTEDRIGHT", '<i class="fa fa-quote-right quote-icons" style=""></i>', $content);

		$videoPageInfo = Page::getPageInfo(12);
		
		return view('ess-kay-homepage', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'page_content' => $content1, 'video_content' => $videoPageInfo->content]);
		
	}
	
	public function news()
    {	
		$customer_name = session()->get('esskay_verify');
		
		$getArticles = \DB::table('articles')->where(['status' => 'PUBLISHED'])->get();
		$articleData = array();
		
		if($getArticles)
		{
			foreach($getArticles as $getArticle)
			{
				$getCategories = \DB::table('categories')->leftJoin('article_category', 'categories.id', '=', 'article_category.category_id')->where('article_id', $getArticle->id)->get();
				
				$categoryName = $categoryName0 = "";
				foreach($getCategories as $category)
				{
					$categoryName .= $category->name.", ";
					$categoryName0 .= "post-row-".$category->name."::";
				}
				
				$categoryName2 = strtolower(str_replace(" ", "-", $categoryName0));
				$categoryName2 = str_replace("::", " ", $categoryName2);
				$categoryName1 = substr(trim($categoryName), 0, -1);
				//$categoryName2 = substr(trim($categoryName0), 0, -1);
				
				$short_description = preg_replace('/\s+?(\S+)?$/', '', substr($getArticle->short_description, 0, 120)).'...'; // $this->short_name($getArticle->short_description, 30);
				
				$articleData[] = array('id' => $getArticle->id, 'title' => $getArticle->title, 'short_description_full' => $getArticle->short_description, 'short_description' => $short_description, 'content' => $getArticle->content, 'image' => $getArticle->image, 'article_pdf' => $getArticle->article_pdf, 'date' => $getArticle->date, 'category_id' => $categoryName1, 'category_name' => $categoryName2);
			}
		}
		
		$getCategories = \DB::table('categories')->orderBy('depth', 'ASC')->get();
		$categoriesData = array();
		
		if($getCategories)
		{
			foreach($getCategories as $getArticle)
			{
				$getArticleCount = \DB::table('article_category')->where(['category_id' => $getArticle->id])->count();
				
				$categoriesData[] = array('name' => $getArticle->name, 'name1' => strtolower(str_replace(" ", "-", $getArticle->name)), 'count' => $getArticleCount);
			}
		}
		
		return view('ess-kay-news', ['customer_name' => $customer_name, 'articleData' => $articleData, 'categoriesData' => $categoriesData]);
		
	}
	
	public function short_name($str, $limit)
	{
		if ($limit < 3) $limit = 3;

		if (strlen($str) > $limit) {
			$str = substr($str, 0, strpos(wordwrap($str, $limit), "\\"));
		}

		return $str;
	}
	
	public function contactUs()
    {	
		$pageInfo = Page::getPageInfo(2);
		
		$customer_name = session()->get('esskay_verify');
		
		Setting::assignSetting();
		
		return view('ess-kay-contact', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'page_content' => $pageInfo->content]);
		
	}
	
	public function companyGraph()
    {	
		$pageInfo = Page::getPageInfo(7);
		
		$customer_name = session()->get('esskay_verify');
		
		Setting::assignSetting();
		
		$chart1 = $chart2 = $chart3 = $chart4 = $chart5 = array();
		
		
		$remarks1 = $remarks2 = $remarks3 = $remarks4 = $remarks5 = "";
		
		$graph1 = \DB::table('analytics_graphs')->leftJoin('analytics_graph_details', 'analytics_graphs.id', '=', 'analytics_graph_details.analytics_graph_id')->where('analytics_graphs.id', '1')->orderBy('analytics_graph_details.id', 'ASC')->get();
		
		if($graph1)
		{
			$remarks1 = $graph1[0]->remarks;

			$yaxislable1 = ($graph1[0]->analytics_Ylable != "") ? $graph1[0]->analytics_Ylable : 'Data'; 
			
			$categories0 = $categories01 = $categories02 = "";
			$categories1 = $categories2 = $categories3 = $categories4 = $categories5 = $categories6 = array();
			foreach($graph1 as $row1)
			{
				$categories0 = $row1->graph_heading;
				$categories1[] = $row1->graph_category;
				$categories2[] = (int)$row1->graph_value;
				
				if($row1->graph_heading1 != "")
				{
					$categories01 = $row1->graph_heading1;
					$categories3[] = $row1->graph_category1;
					$categories4[] = (int)$row1->graph_value1;
				}
				
				if($row1->graph_heading2 != "")
				{
					$categories02 = $row1->graph_heading2;
					$categories5[] = $row1->graph_category2;
					$categories6[] = (int)$row1->graph_value2;
				}
			}
			$chart1 = \Chart::title([
				'text' => $graph1[0]->analytics_title,
			])
			->chart([
				'type'     => 'column', // pie , columnt ect
				'renderTo' => 'first_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->credits([
				'enabled' => 'false'
			])
			->xaxis([
				'categories' => $categories1,
				'labels'     => [
					'rotation'  => 15,
					'align'     => 'top',
					'enabled' => true,
					
					// use 'startJs:yourjavasscripthere:endJs'
				],
			])
			->yaxis([
				'title'     => [
					'enabled' => true,
					'text' => $yaxislable1
				],
			])
			->legend([
				'layout'        => 'vertical',
				'align'         => 'right',
				'verticalAlign' => 'middle',
			])
			->series(
				[
					[
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'name'  => $categories02,
						'data'  => $categories6,
					],
				]
			)
			->display(0);
		}
		
		$graph1 = \DB::table('analytics_graphs')->leftJoin('analytics_graph_details', 'analytics_graphs.id', '=', 'analytics_graph_details.analytics_graph_id')->where('analytics_graphs.id', '2')->orderBy('analytics_graph_details.id', 'ASC')->get();
		if($graph1)
		{
			$remarks2 = $graph1[0]->remarks;

			$yaxislable1 = ($graph1[0]->analytics_Ylable != "") ? $graph1[0]->analytics_Ylable : 'Data'; 
			
			$categories0 = $categories01 = $categories02 = "";
			$categories1 = $categories2 = $categories3 = $categories4 = $categories5 = $categories6 = array();
			foreach($graph1 as $row1)
			{
				$categories0 = $row1->graph_heading;
				$categories1[] = $row1->graph_category;
				$categories2[] = (int)$row1->graph_value;
				
				if($row1->graph_heading1 != "")
				{
					$categories01 = $row1->graph_heading1;
					$categories3[] = $row1->graph_category1;
					$categories4[] = (int)$row1->graph_value1;
				}
				
				if($row1->graph_heading2 != "")
				{
					$categories02 = $row1->graph_heading2;
					$categories5[] = $row1->graph_category2;
					$categories6[] = (int)$row1->graph_value2;
				}
			}
			
			$chart2 = \Chart::title([
				'text' => $graph1[0]->analytics_title,
			])
			->chart([
				'type'     => 'column', // pie , columnt ect
				'renderTo' => 'second_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->credits([
				'enabled' => 'false'
			])
			->xaxis([
				'categories' => $categories1,
				'labels'     => [
					'rotation'  => 15,
					'align'     => 'top',
					'enabled' => true,
					
					// use 'startJs:yourjavasscripthere:endJs'
				],
			])
			->yaxis([
				'title'     => [
					'enabled' => true,
					'text' => $yaxislable1
				],
			])
			->legend([
				'layout'        => 'vertical',
				'align'         => 'right',
				'verticalAlign' => 'middle',
			])
			->series(
				[
				[
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'name'  => $categories02,
						'data'  => $categories6,
					],
				]
			)
			->display(0);
		}
		
		$graph1 = \DB::table('analytics_graphs')->leftJoin('analytics_graph_details', 'analytics_graphs.id', '=', 'analytics_graph_details.analytics_graph_id')->where('analytics_graphs.id', '3')->orderBy('analytics_graph_details.id', 'ASC')->get();
		if($graph1)
		{
			$remarks3 = $graph1[0]->remarks;

			$yaxislable1 = ($graph1[0]->analytics_Ylable != "") ? $graph1[0]->analytics_Ylable : 'Data'; 
			
			$categories0 = $categories01 = $categories02 = "";
			$categories1 = $categories2 = $categories3 = $categories4 = $categories5 = $categories6 = array();
			foreach($graph1 as $row1)
			{
				$categories0 = $row1->graph_heading;
				$categories1[] = $row1->graph_category;
				$categories2[] = (int)$row1->graph_value;
				
				if($row1->graph_heading1 != "")
				{
					$categories01 = $row1->graph_heading1;
					$categories3[] = $row1->graph_category1;
					$categories4[] = (int)$row1->graph_value1;
				}
				
				if($row1->graph_heading2 != "")
				{
					$categories02 = $row1->graph_heading2;
					$categories5[] = $row1->graph_category2;
					$categories6[] = (int)$row1->graph_value2;
				}
			}
			
			$chart3 = \Chart::title([
				'text' => $graph1[0]->analytics_title,
			])
			->chart([
				'type'     => 'column', // pie , columnt ect
				'renderTo' => 'third_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				
			])
			->credits([
				'enabled' => 'false'
			])
			->xaxis([
				'categories' => $categories1,
				'labels'     => [
					'rotation'  => 15,
					'align'     => 'top',
					'enabled' => true,
					
					// use 'startJs:yourjavasscripthere:endJs'
				],
			])
			->yaxis([
				'title'     => [
					'enabled' => true,
					'text' => $yaxislable1
				],
			])
			->legend([
				'layout'        => 'vertical',
				'align'         => 'right',
				'verticalAlign' => 'middle',
			])
			->series(
				[
					[
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'name'  => $categories02,
						'data'  => $categories6,
					],
				]
			)
			->display(0);
		}
		
		$graph1 = \DB::table('analytics_graphs')->leftJoin('analytics_graph_details', 'analytics_graphs.id', '=', 'analytics_graph_details.analytics_graph_id')->where('analytics_graphs.id', '4')->orderBy('analytics_graph_details.id', 'ASC')->get();
		if($graph1)
		{
			$remarks4 = $graph1[0]->remarks;

			$yaxislable1 = ($graph1[0]->analytics_Ylable != "") ? $graph1[0]->analytics_Ylable : 'Data'; 
			
			$categories1 = $categories2 = $categories3 = $categories4 = $categories5 = $categories6 = array();
			foreach($graph1 as $row1)
			{
				$categories2[] = array('name' => $row1->graph_category, 'y' => (int)$row1->graph_value);
			}
			
			//dd($categories2);
			
			$chart4 = \Chart::title([
				'text' => $graph1[0]->analytics_title,
			])
			->chart([
				'type'     => 'pie', // pie , columnt ect
				'renderTo' => 'fourth_chart', // render the chart into your div with id
				'point' => ([
					'valueSuffix' => '%'
				])
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->credits([
				'enabled' => 'false'
			])
			->plotOptions([
				'pie' => ([
					'allowPointSelect' => 'true',
					'cursor' => 'pointer',
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
						'style' => [
							'color' => '#666666',
							'fontWeight' => 'normal'
						]
					])
				])
			])
			->xaxis([
				'categories' => [],
				'labels'     => [
					'rotation'  => 15,
					'align'     => 'top',
					'enabled' => true,
					// use 'startJs:yourjavasscripthere:endJs'
				],
			])
			->yaxis([
				'title'     => [
					'enabled' => true,
					'text' => $yaxislable1
				],
			])
			->legend([
				'layout'        => 'vertical',
				'align'         => 'right',
				'verticalAlign' => 'middle',
			])
			->series(
				[
					[
						'name'  => 'Text',
						'colorByPoint' => 'true',
						'data'  => $categories2,
						// 'color' => '#0c2959',
					],
				]
			)
			->display(0);
		}
		
		$graph1 = \DB::table('analytics_graphs')->leftJoin('analytics_graph_details', 'analytics_graphs.id', '=', 'analytics_graph_details.analytics_graph_id')->where('analytics_graphs.id', '5')->orderBy('analytics_graph_details.id', 'ASC')->get();
		if($graph1)
		{
			$remarks5 = $graph1[0]->remarks;

			$yaxislable1 = ($graph1[0]->analytics_Ylable != "") ? $graph1[0]->analytics_Ylable : 'Data'; 
			
			$categories1 = $categories2 = $categories3 = $categories4 = $categories5 = $categories6 = array();
			foreach($graph1 as $row1)
			{
				$categories2[] = array('name' => $row1->graph_category, 'y' => (int)$row1->graph_value);
			}
			
			$chart5 = \Chart::title([
				'text' => $graph1[0]->analytics_title,
			])
			->chart([
				'type'     => 'pie', // pie , columnt ect
				'renderTo' => 'fifth_chart', // render the chart into your div with id
				'point' => ([
					'valueSuffix' => '%'
				])
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->credits([
				'enabled' => 'false'
			])
			->plotOptions([
				'pie' => ([
					'allowPointSelect' => 'true',
					'cursor' => 'pointer',
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
						'style' => [
							'color' => '#666666',
							'fontWeight' => 'normal'
						]
					])
				])
			])
			->xaxis([
				'categories' => [],
				'labels'     => [
					'rotation'  => 15,
					'align'     => 'top',
					'enabled' => true,
					// use 'startJs:yourjavasscripthere:endJs'
				],
			])
			->yaxis([
				'title'     => [
					'enabled' => true,
					'text' => $yaxislable1
				],
			])
			->legend([
				'layout'        => 'vertical',
				'align'         => 'right',
				'verticalAlign' => 'middle',
			])
			->series(
				[
					[
						'name'  => 'Text',
						'colorByPoint' => 'true',
						'data'  => $categories2,
						// 'color' => '#0c2959',
					],
				]
			)
			->display(0);
		}
		
		
		return view('ess-kay-company-graph', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'heading_title' => $pageInfo->title, 'page_content' => $pageInfo->content, 'graph_content' => $pageInfo->content, 'chart1' => $chart1, 'chart2' => $chart2, 'chart3' => $chart3, 'chart4' => $chart4, 'chart5' => $chart5, 'remarks1' => $remarks1, 'remarks2' => $remarks2, 'remarks3' => $remarks3, 'remarks4' => $remarks4, 'remarks5' => $remarks5]);
		
	}
	
	public function assignDate(Request $request)
    {
		$date = $request->date;
		
		session ( [
			'esskay_doc_date' => $date
		] );
	}
	
	public function document()
    {	
    	$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$parentData = \DB::table('document_category')->leftJoin('document_category_lender', 'document_category.id', '=', 'document_category_lender.document_category_id')->where('document_category_lender.lender_id',$lender_id)->whereNull('document_category.parent_id')->orderBy('document_category.lft', 'ASC')->get();
		//dd($parentData); 
		$parentCategoryData = $childCategoryData = $childChildCategoryData = array();
		
		if($parentData)
		{
			foreach($parentData as $parentRow)
			{
				$parentCategoryData[$parentRow->id] = array('name' => $parentRow->name, 'image' => url('/')."/".$parentRow->category_image);
				
				//$childData = \DB::table('document_category')->where('parent_id', $parentRow->id)->orderBy('lft', 'ASC')->get();
				$childData = \DB::table('document_category')->leftJoin('document_category_lender', 'document_category.id', '=', 'document_category_lender.document_category_id')->where('document_category_lender.lender_id',$lender_id)->where('document_category.parent_id', $parentRow->id)->orderBy('document_category.lft', 'ASC')->get();
				if($childData)
				{
					foreach($childData as $childRow)
					{
						$childCategoryData[$parentRow->id][$childRow->id] = array('name' => $childRow->name, 'image' => url('/')."/".$childRow->category_image);
					}
				}
			}
		}
		
		//echo "<pre> Parent"; print_r($parentCategoryData); 
		//echo "child"; print_r($childCategoryData);
		
		
		$document_date = array();
		for($count=date('Y');$count>=2015;$count--)
		{
			$document_date[$count] = $count;
		}
		
		session ( [
			'esskay_doc_date' => date('Y')
		] );

		$current_year = date('Y');
		
		return view('ess-kay-document', ['documentDateData' => $document_date, 'parentCategoryData' => $parentCategoryData, 'childCategoryData' => $childCategoryData, 'childChildCategoryData' => $childChildCategoryData, 'lenderData' => $lenderData, 'current_year' => $current_year]);
	}

	public function sendUserOtp(){
		$userRecord = \DB::table('users')->where(['id' => session()->get('esskay_user_id'), 'user_status' => '1'])->first();
		if($userRecord){
			$user_otp = rand(111111, 999999);
			$updateData = array('user_otp' => $user_otp, 'updated_at' => date('Y-m-d H:i:s'));
				\DB::table('users')->where(['id' => $userRecord->id])->update($updateData);
				
			$message = str_replace(" ", "%20", "Dear ".$userRecord->name.", please use this OTP ".$user_otp." to login");
					
			$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$userRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
			$result = $this->getContent($request_url);

			return redirect(url('/edit-password'));
		}

	}
	// Update Password
	public function editPassword()
    {
		Setting::assignSetting();
		
		//$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if(!session()->get('esskay_user_id'))
		{
			return redirect(url('/'));
		}
		else
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('esskay_user_id'), 'user_status' => '1'])->first();
			//dd($userRecord);
			
			$riders = array();
			return view('edit-password', ['customer_name' => $userRecord->name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
	}
	
	public function updatePassword(Request $request)
    {
		$rules = array (
			'user_otp' => 'required',
			'password' => 'required',
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		if ($validator->fails ()) {
			echo "<div class='alert alert-danger'>Please correct all entries.</div>";
		}
		else
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('esskay_user_id'), 'user_status' => '1'])->first();
			
			if($userRecord)
			{
				if($userRecord->user_otp == $request->user_otp)
				{
					$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
					\DB::table('users')->where(['id' => session()->get('esskay_user_id')])->update($updateData);
					
					// Send SMS
					$message = str_replace(" ", "%20", "Dear ".$userRecord->name.", your password has been changed successfully. In case you haven't changed the password recently, please contact us at +91-7014592698");
					
					$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$userRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
					$result = $this->getContent($request_url);
					
					// Send Mail
					/*$contactData = array('first_name' => $userRecord->name, 'email' => $userRecord->email, 'telephone' => $userRecord->phone, 'user_message' => $userRecord->message);
					$tempUserData = array('email' => $userRecord->email, 'name' => $userRecord->name);
					
					Mail::send('emails.change_password', $contactData, function ($message) use ($tempUserData) {
						$message->to($tempUserData['email'], $tempUserData['name'])->subject("Change Password");
						$message->cc('communication@skfin.in');
						$message->from('communication@skfin.in', 'Ess Kay Fincorp');
					});*/
	
					echo 1;
				}
				else
				{
					echo "<div class='alert alert-danger'>OTP Mistamtch. Please try again.</div>";
				}
				
			} else {
				echo "<div class='alert alert-danger'>User not exists. Please try again.</div>";
			}
		}
	}


	// Terms Page Content
	public function termsPage()
    {
		Setting::assignSetting();
		
		
		$pageInfo = Page::getPageInfo(8);
		
		$pageData = json_decode($pageInfo->extras);
		//dd($pageData);
		return view('page', ['title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'pageheading' => $pageInfo->name, 'content' => $pageInfo->content]);
		
	}
}
