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
		$trustee_name = session()->get('esskay_trustee_verify');
		
		$pageInfo = Page::getPageInfo(1);
		$pageData = json_decode($pageInfo['extras']);
		
		
		if($customer_name || $trustee_name)
		{
			if($customer_name)
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
				
				//dd($lenderData);

				// Lender Banking Assessment
				$bankingData = \DB::table('lender_banking')->leftJoin('banking_arrangment', 'lender_banking.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->selectRaw('lender_banking.*,banking_arrangment.name')->get();

				$lenderBankingData = $lenderBankingDetailData = array();
				foreach ($bankingData as $bdata) {
					# code...
					if($bdata->lender_banking_status == 1 && ($bdata->sanction_amount > 0.00 || $bdata->outstanding_amount > 0.00)) {
						$lenderBankingData[] = array('lender_id' => $bdata->lender_id,'banking_arrangment_id' => $bdata->banking_arrangment_id,'banking_arrangment_name' => $bdata->name,'sanction_amount' => $bdata->sanction_amount,'outstanding_amount' => $bdata->outstanding_amount);

						// Inner Data
						$bankingInnerData = \DB::table('lender_banking_details')->leftJoin('banking_arrangment', 'lender_banking_details.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->where('lender_banking_id', $bdata->id)->get();

						foreach ($bankingInnerData as $bdataInner) {
							if($bdataInner->lender_banking_status == 1 && ($bdataInner->sanction_amount > 0.00 || $bdataInner->outstanding_amount > 0.00)) {
									$lenderBankingDetailData[$bdata->banking_arrangment_id][] = array('lender_banking_date' => date('d M Y', strtotime($bdataInner->lender_banking_date)), 'sanction_amount' => $bdataInner->sanction_amount, 'outstanding_amount' => $bdataInner->outstanding_amount);
							}
						}
					}else{
						$bankingData_r = \DB::table('lender_banking_revisions')->leftJoin('banking_arrangment', 'lender_banking_revisions.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->where('banking_arrangment_id', $bdata->banking_arrangment_id)->where('lender_banking_revisions.lender_banking_status', '1')->orderby('lender_banking_revisions.id','DESC')->selectRaw('lender_banking_revisions.*,banking_arrangment.name')->first();
						if($bankingData_r){
							$lenderBankingData[] = array('lender_id' => $bankingData_r->lender_id,'banking_arrangment_id' => $bankingData_r->banking_arrangment_id,'banking_arrangment_name' => $bankingData_r->name,'sanction_amount' => $bankingData_r->sanction_amount,'outstanding_amount' => $bankingData_r->outstanding_amount);

							// Inner Data
							$bankingInnerData = \DB::table('lender_banking_details')->leftJoin('banking_arrangment', 'lender_banking_details.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->where('lender_banking_id', $bankingData_r->lender_banking_id)->get();

							foreach ($bankingInnerData as $bdataInner) {
								if($bdataInner->lender_banking_status == 1 && ($bdataInner->sanction_amount > 0.00 || $bdataInner->outstanding_amount > 0.00)) {
										$lenderBankingDetailData[$bdata->banking_arrangment_id][] = array('lender_banking_date' => date('d M Y', strtotime($bdataInner->lender_banking_date)), 'sanction_amount' => $bdataInner->sanction_amount, 'outstanding_amount' => $bdataInner->outstanding_amount);
								}
							}
						}
					}
				}

				$total_outstanding = $total_sanction = 0;

				foreach($lenderBankingData as $row)
				{
					$total_outstanding+= $row['outstanding_amount'];
					$total_sanction+= $row['sanction_amount'];
				}
				
				$lenderCode = "";
				return view('ess-kay-home', ['customer_name' => $customer_name, 'parentCategoryData' => $parentCategoryData, 'childCategoryData' => $childCategoryData, 'lenderData' => $lenderData, 'lenderCode' => $lenderCode, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'lenderBankingData' => $lenderBankingData, 'lenderBankingDetailData' => $lenderBankingDetailData, 'lenderCount' => count($lenderBankingData), 'total_outstanding' => $total_outstanding, 'total_sanction' => $total_sanction]);
			}
			else if($trustee_name)
			{
				$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
				$trustee_id = $trusteeData->id;
				$trusteeCode = "";

				// TO DO
				$docCategoryData = \DB::table('transaction_categories')->leftJoin('transaction_category_trustee', 'transaction_categories.id', '=', 'transaction_category_trustee.transaction_category_id')->where('transaction_category_trustee.trustee_id',$trustee_id)->groupBy('transaction_category_trustee.transaction_category_id')->get();

				return view('ess-kay-trusee-home', ['customer_name' => $trustee_name, 'trusteeCode' => $trusteeCode, 'trusteeData' => $trusteeData, 'docCategoryData' => $docCategoryData, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
			}
		}
		else
		{
			return redirect(url('/').'/login');
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

	
	public function saveResendLoginOtp(Request $request)
    {
    	$login_phone_number = session()->get('login_phone_number');
    	$checkRecord = \DB::table('users')->where(['phone' => $login_phone_number, 'user_status' => '1'])->first();
				
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
						return 0;
					}
				}

				// update otp
				/*$user_otp = rand(111111, 999999);
				$updateData = array('user_otp' => $user_otp, 'updated_at' => date('Y-m-d H:i:s'));
				\DB::table('users')->where(['id' => $user_id])->update($updateData);*/

				$modelRole = \DB::table('model_has_roles')->where('model_id', $user_id)->first();

				$is_model = 0;
				if($modelRole)
				{
					if($modelRole->role_id == '4')
					{
						$is_model = 1;							
					}
					else if($modelRole->role_id == '11')
					{
						$is_model = 1;
					}
				}

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
				
				//\DB::table('user_login')->insert(['user_id' => $user_id, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'phone', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

				if($is_model == 1)
				{
					return 1;
				} else {
					Session::flash ( 'message', "Something went wrong or you do not have permission to access this page." );
					return 0;
				}
			} else {
				Session::flash ( 'message', "Invalid Credentials, Please try again." );
				return 0;
			}
		} else {
			Session::flash ( 'message', "Phone Number not exists or not activated yet. Please try again." );
			return 0;
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

					$modelRole = \DB::table('model_has_roles')->where('model_id', $user_id)->first();

					session ( [
						'login_phone_number' => $request->phone
					] );

					$is_model = 0;
					if($modelRole)
					{
						if($modelRole->role_id == '4')
						{
							$is_model = 1;							
						}
						else if($modelRole->role_id == '11')
						{
							$is_model = 1;
						}
					}

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

					if($is_model == 1)
					{
						return redirect(url('/user_otp'));
					} else {
						Session::flash ( 'message', "Something went wrong or you do not have permission to access this page." );
						return Redirect::back ();
					}
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

		session()->forget('esskay_trustee_name');
		session()->forget('esskay_trustee_user_id');
		session()->forget('esskay_trustee_verify');
		session()->forget('role_id');
		
		return redirect(url('/').'/');
	}
	
	// Login (login with phone)
	public function userOTP()
    {
		Setting::assignSetting();
		
		$customer_name = session()->get('login_phone_number');
		//$customer_name1 = session()->get('esskay_trustee_name');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name)
		{
			$checkRecord = \DB::table('users')->where(['phone' => $customer_name])->first();
			
			$user_otp = $checkRecord->user_otp;
			return view('user_otp', ['customer_name' => $customer_name, 'user_otp' => $user_otp, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
			
		}
		else if($customer_name1)
		{
			$checkRecord = \DB::table('users')->where(['phone' => $customer_name])->first();
			
			$user_otp = $checkRecord->user_otp;
			return view('user_otp', ['customer_name' => $customer_name1, 'user_otp' => $user_otp, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
			
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
			$message->to($tempUserData['email'], $tempUserData['name'])->subject("Contact Us from Lender");
			$message->from('communication@skfin.in', 'Ess Kay Fincorp');
		});
		
		echo "Thanks for your contact. Our team will get back to you within 24-48 hours";
	}

	public function saveContactTrustee(Request $request)
    {
		\DB::table('contact_us')->insert(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'telephone' => $request->telephone, 'message' => $request->message]);
		
		\DB::table('email_sms')->insert(['send_type' => 'email', 'send_to' => $request->email, 'send_subject' => 'Contact Us', 'send_message' => $request->message, 'is_deliver' => '1']);
		
		$contactData = array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'telephone' => $request->telephone, 'user_message' => $request->message);
		$tempUserData = array('email' => $request->email, 'name' => $request->first_name." ".$request->last_name);
		
		Mail::send('emails.contact_us', $contactData, function ($message) use ($tempUserData) {
			$message->to($tempUserData['email'], $tempUserData['name'])->subject("Contact Us from Trustee");
			$message->from('communication@skfin.in', 'Ess Kay Fincorp');
		});
		
		echo "Thanks for your contact. Our team will get back to you within 24-48 hours";
	}
	
	public function browserInfo(Request $request)
    {
		$browserDetails = $request->header('User-Agent');
		//dd($browserDetails);
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
					'showInLegend' => 'false',
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
    {
    	// Download file
    	$customer_name = session()->get('esskay_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			// Download file
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
	}

	public function previewDoc($doc_id)
    {
    	$customer_name = session()->get('esskay_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
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
	}
	
	public function downloadFile($doc_id)
    {	
    	// Download file
    	$customer_name = session()->get('esskay_verify');
    	$customer_name1 = session()->get('esskay_trustee_verify');
		
		if($customer_name || $customer_name1)
		{
			$docData  = \DB::table('articles')->where('id', '=', $doc_id)->first();
			
			$file= public_path(). "/".$docData->article_pdf;
			
			$article_pdf = explode("/", $docData->article_pdf);
			$doc = array_pop($article_pdf);

			if($customer_name)
			{
				\DB::table('user_pdf')->insert(['user_id' => session()->get('esskay_user_id'), 'article_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			}

			if($customer_name1)
			{
				\DB::table('user_pdf')->insert(['user_id' => session()->get('esskay_trustee_user_id'), 'article_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			}
			
			return response()->download($file, $doc);
		}
		else
		{
			return redirect(url('/').'/login');
		}
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
					else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
					else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
		$customer_name1 = session()->get('esskay_trustee_verify');
		
		$pageInfo = Page::getPageInfo(3);
		$pageData = json_decode($pageInfo['extras']);
		
		if($customer_name || $customer_name1)
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
    	$customer_name = session()->get('esskay_verify');
		$trustee_name = session()->get('esskay_trustee_verify');
		
		if($customer_name || $trustee_name)
		{
			return redirect()->route('dashboard');
		}

		// TO DO
		$messages = [
			'agree_login.required' => 'You must agree to the Terms and Conditions',
		];

		$rules = array (
			'email' => 'required',
			'password' => 'required',
			'agree_login' => 'required',
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
			$json = ['message' => $validator, 'success' => 0];
			return response()->json($json);
		}
		else
		{
			if ($resultJson->success != true) {
				$json = ['message' => "Please refresh the page and try login in again", 'success' => 0];

				return response()->json($json);
				
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

									$modelRole = \DB::table('model_has_roles')->where('model_id', $user_id)->first();

									$is_model = 0;
									if($modelRole)
									{
										if($modelRole->role_id == '4')
										{
											$is_model = 1;
											session ( [
												'login_phone_number' => $checkRecord->phone,
												'esskay_name' => $checkRecord->email,
												'esskay_user_id' => $user_id,
												//'esskay_verify' => '1',
												'role_id' => $modelRole->role_id
											] );
										}
										else if($modelRole->role_id == '11')
										{
											$is_model = 1;
											session ( [
												'login_phone_number' => $checkRecord->phone,
												'esskay_trustee_name' => $checkRecord->email,
												'esskay_trustee_user_id' => $user_id,
												//'esskay_trustee_verify' => '1',
												'role_id' => $modelRole->role_id
											] );
										}

										if($is_model == 1)
										{
											$sms_status = config('general.sms_status');
					
											if($sms_status)
											{
												$message = str_replace(" ", "%20", "Dear ".$checkRecord->name.", please use this OTP ".$checkRecord->user_otp." to login");
												
												$request_url = "https://www.bulksmslive.info/api/sendhttp.php?authkey=6112AIUJ9ujV9spM5cbf0026&mobiles=91".$checkRecord->phone."&message=".$message."&sender=EssKay&route=4&country=0";
												$result = $this->getContent($request_url);
												
												
												if($result['errno'] == 0)
												{
													\DB::table('email_sms')->insert(['send_type' => 'sms', 'send_to' => $checkRecord->phone, 'send_subject' => 'User OTP', 'send_message' => $message, 'is_deliver' => '1']);
												} else {
													Session::flash ( 'message', "Error in sending message. Please re-try" );
													return Redirect::back ();
												}
											}

											$user_login_attempt = 0;
											$updateData = array('login_attempt' => $user_login_attempt, 'updated_at' => date('Y-m-d H:i:s'));
												\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);
											
											\DB::table('user_login')->insert(['user_id' => $user_id, 'user_ip' => $request->ip(), 'user_browser' => $browser." ".$version, 'device_type' => $device_type, 'login_type' => 'email', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

											$json = ['message' => "Logged-in successfully", 'redirect' => url('user_otp'), 'success' => 1];

											return response()->json($json);
										}
										else
										{
											$json = ['message' => "Something went wrong or you do not have permission to access this page.", 'success' => 0];

											return response()->json($json);
										}
									}
									else
									{
										$json = ['message' => "Something went wrong or you do not have permission to access this page.", 'success' => 0];

										return response()->json($json);
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

									$json = ['message' => "Invalid Credentials, Please try again.", 'success' => 0];

									return response()->json($json);
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

								$json = ['message' => "Invalid Credentials, Please try again.", 'success' => 0];

								return response()->json($json);
							}
						} else {
							$json = ['message' => "Email not exists or not activated yet. Please try again.", 'success' => 0];

							return response()->json($json);
						}
					}
				}else{
					$json = ['message' => "Please fill all information and try again", 'success' => 0];

					return response()->json($json);
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
			$checkRecord = \DB::table('users')->where(['phone' => session()->get('login_phone_number')])->where(['user_otp' => $request->user_otp])->first();
			//$checkRecord1 = \DB::table('users')->where(['phone' => session()->get('login_phone_number')])->where(['user_otp' => $request->user_otp])->first();

			//print_r($checkRecord); dd($checkRecord1);
			
			if($checkRecord)
			{
				$user_otp = rand(111111, 999999);
				$updateData = array('user_otp' => $user_otp, 'updated_at' => date('Y-m-d H:i:s'));
				\DB::table('users')->where(['id' => $checkRecord->id])->update($updateData);

				$modelRole = \DB::table('model_has_roles')->where('model_id', $checkRecord->id)->first();

				if($modelRole)
				{
					if($modelRole->role_id == '4')
					{
						session ( [
							'esskay_name' => $checkRecord->email,
							'esskay_user_id' => $checkRecord->id,
							'esskay_verify' => '1',
							'role_id' => $modelRole->role_id
						] );
					}
					else if($modelRole->role_id == '11')
					{
						session ( [
							'esskay_trustee_name' => $checkRecord->email,
							'esskay_trustee_user_id' => $checkRecord->id,
							'esskay_trustee_verify' => '1',
							'role_id' => $modelRole->role_id
						] );
					}
				}

				session()->forget('login_phone_number');
				
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

	public function boardPage()
    {	
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(10);
		//dd($pageInfo);
		
		$content = str_replace("INVERTEDLEFT", '<i class="fa fa-quote-left quote-icons" style=""></i>', $pageInfo->content);
		$content1 = str_replace("INVERTEDRIGHT", '<i class="fa fa-quote-right quote-icons" style=""></i>', $content);
		
		return view('ess-kay-board', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'page_content' => $content1]);
		
	}

	public function keymanagerPage()
    {	
		$customer_name = session()->get('esskay_verify');
		
		$pageInfo = Page::getPageInfo(11);
		//dd($pageInfo);
		
		$content = str_replace("INVERTEDLEFT", '<i class="fa fa-quote-left quote-icons" style=""></i>', $pageInfo->content);
		$content1 = str_replace("INVERTEDRIGHT", '<i class="fa fa-quote-right quote-icons" style=""></i>', $content);
		
		return view('ess-kay-key-manager', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'page_content' => $content1]);
		
	}

	// Insight
	public function insight()
    {	
    	$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$parentData = \DB::table('insight_categories')->leftJoin('insight_category_lender', 'insight_categories.id', '=', 'insight_category_lender.insight_category_id')->where('insight_category_lender.lender_id',$lender_id)->whereNull('insight_categories.parent_id')->where('status', '1')->orderBy('insight_categories.lft', 'ASC')->get();
		//dd($parentData); 
		$parentCategoryData = array();
		
		if($parentData)
		{
			foreach($parentData as $parentRow)
			{
				$parentCategoryData[$parentRow->id] = $parentRow->name;
			}
		}
		
		return view('ess-kay-insight', ['parentCategoryData' => $parentCategoryData, 'lenderData' => $lenderData]);
	}

	public function deal()
	{
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_lender', 'current_deal_category_lender.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_lender.lender_id',$lender_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
		
		return view('ess-kay-deal', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'lenderData' => $lenderData]);
	}

	// Search
	public function dealSearch(Request $request)
	{
		$deal_filterby = $request->deal_filterby;
		$deal_rating = $request->deal_rating;


		$category_name = "";

		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_lender', 'current_deal_category_lender.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_lender.lender_id',$lender_id)->where('status', '1')->get();

		if($deal_filterby != "")
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
			}
			else
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
			}
		}
		else
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
			}
		}
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'lenderData' => $lenderData]);
	}

	// Sort
	public function dealSort(Request $request)
	{
		$category_name = '';
		$sort_value = $request->sort_value;

		$sortData = explode("-", $sort_value);

		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_lender', 'current_deal_category_lender.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_lender.lender_id',$lender_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'lenderData' => $lenderData]);
	}

	public function dealGrid()
	{
		$category_name = "";
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_lender', 'current_deal_category_lender.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_lender.lender_id',$lender_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'lenderData' => $lenderData]);
	}

	public function dealList()
	{
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;
    	$category_name = "";

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_lender', 'current_deal_category_lender.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_lender.lender_id',$lender_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
		
		return view('ess-kay-deal-list', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'lenderData' => $lenderData]);
	}

	public function sanctionLetter()
    {	
    	$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$sanctionData = \DB::table('sanction_letters')->where('status', '1')->get();
		
		return view('ess-kay-sanction-letter', ['sanctionData' => $sanctionData, 'lenderData' => $lenderData]);
	}

	// Lender
	public function showInsight(Request $request)
    {
		//dd($request->all());
		$lenderData = \DB::table('lenders')->where('user_id', session()->get('esskay_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;
		
		$insightCatData = \DB::table('insight_categories')->where('id', '=', $request->category_id)->first();

		$insightData = \DB::table('operational_highlights')->where('operational_highlight_status', 1)->get();

		$insightFirst = \DB::table('operational_highlights')->where('operational_highlight_status', 1)->first();

		$geographicalConData = $geographicalConTotalData = array();
		$productConData = $productConTotalData = array();
		$netWorthData = $netWorthData1 = $liquidityData = $liabilityProfileData = $liabilityProfile11Data = $liquidityDataTotal = array();

		$covidReliefData = $covidReliefDataTotal = $covidReliefDataTotal1 = array();
		$covidRelief1Data = $covidRelief1DataTotal = $covidRelief1DataTotal1 = array();

		$chart1 = $chart2 = $chart3 = $chart41 = $chart42 = $chart51 = $chart52 = $chart6 = $chart7 = array();

		if($request->category_id == 3)
		{
			$geographicalConData = \DB::table('geographical_concentrations')->where('geographical_concentration_status', 1)->get();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = $amount10 = 0;

			$raj_amount1 = $raj_amount2 = $raj_amount3 = $raj_amount4 = $raj_amount5 = $raj_amount6 = $raj_amount7 = $raj_amount8 = $raj_amount9 = 0;
			$other_amount1 = $other_amount2 = $other_amount3 = $other_amount4 = $other_amount5 = $other_amount6 = $other_amount7 = $other_amount8 = $other_amount9 = 0;

			$geographicalConRajData = \DB::table('geographical_concentrations')->where('geographical_diversification', "Rajasthan")->where('geographical_concentration_status', 1)->first();

			if($geographicalConRajData)
			{
				$raj_amount1 = (int)$geographicalConRajData->amount_percentage1;
				$raj_amount2 = (int)$geographicalConRajData->amount_percentage2;
				$raj_amount3 = (int)$geographicalConRajData->amount_percentage3;
				$raj_amount4 = (int)$geographicalConRajData->amount_percentage4;
				$raj_amount5 = (int)$geographicalConRajData->amount_percentage5;
				$raj_amount6 = (int)$geographicalConRajData->amount_percentage6;
				$raj_amount7 = (int)$geographicalConRajData->amount_percentage7;
				$raj_amount8 = (int)$geographicalConRajData->amount_percentage8;
				$raj_amount9 = (int)$geographicalConRajData->amount_percentage9;
			}

			foreach($geographicalConData as $geographicalConRow)
			{
				$amount1+=$geographicalConRow->amount1;
				$amount2+=$geographicalConRow->amount2;
				$amount3+=$geographicalConRow->amount3;
				$amount4+=$geographicalConRow->amount4;
				$amount5+=$geographicalConRow->amount5;
				$amount6+=$geographicalConRow->amount6;
				$amount7+=$geographicalConRow->amount7;
				$amount8+=$geographicalConRow->amount8;
				$amount9+=$geographicalConRow->amount9;

				if($geographicalConRow->geographical_diversification != "Rajasthan")
				{
					$other_amount1+= $geographicalConRow->amount_percentage1;
					$other_amount2+= $geographicalConRow->amount_percentage2;
					$other_amount3+= $geographicalConRow->amount_percentage3;
					$other_amount4+= $geographicalConRow->amount_percentage4;
					$other_amount5+= $geographicalConRow->amount_percentage5;
					$other_amount6+= $geographicalConRow->amount_percentage6;
					$other_amount7+= $geographicalConRow->amount_percentage7;
					$other_amount8+= $geographicalConRow->amount_percentage8;
					$other_amount9+= $geographicalConRow->amount_percentage9;
				}

				$geographicalConTotalData = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9);
			}

			$chart1 = \Chart::title([
				'text' => 'Geographical Concentration',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'first_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000'
			])
			->xaxis([
				'categories' => [
					'FY16', 'FY17', 'FY18', 'FY19', 'FY20', 'H1FY21', 'FY21',//, 'FY22',//, 'FY23'
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->exporting_js(true)
			->export_data_js(true)
			/*->legend([
				'layout' => 'vertical',
		        'align' => 'right',
		        'verticalAlign' => 'middle'
			])*/
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '{y}%',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Rajasthan',
						'data'  => [$raj_amount1, $raj_amount2, $raj_amount3, $raj_amount4, $raj_amount5, $raj_amount6, $raj_amount7], //, , $raj_amount8 $raj_amount9
					],
					[
						'showInLegend' => 'false',
						'name'  => 'Other States',
						'data'  => [$other_amount1, $other_amount2, $other_amount3, $other_amount4, $other_amount5, $other_amount6, $other_amount7], // , $other_amount8$other_amount9
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 4)
		{
			$productConData = \DB::table('product_concentrations')->where('product_concentration_status', 1)->get();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = $amount10 = 0;

			$raj_amount1 = $raj_amount2 = $raj_amount3 = $raj_amount4 = $raj_amount5 = $raj_amount6 = $raj_amount7 = $raj_amount8 = $raj_amount9 = 0;
			$other_amount1 = $other_amount2 = $other_amount3 = $other_amount4 = $other_amount5 = $other_amount6 = $other_amount7 = $other_amount8 = $other_amount9 = 0;

			$geographicalConRajData = \DB::table('product_concentrations')->where('product_diversification', "Commercial Vehicle")->where('product_concentration_status', 1)->first();

			if($geographicalConRajData)
			{
				$raj_amount1 = (int)$geographicalConRajData->amount_percentage1;
				$raj_amount2 = (int)$geographicalConRajData->amount_percentage2;
				$raj_amount3 = (int)$geographicalConRajData->amount_percentage3;
				$raj_amount4 = (int)$geographicalConRajData->amount_percentage4;
				$raj_amount5 = (int)$geographicalConRajData->amount_percentage5;
				$raj_amount6 = (int)$geographicalConRajData->amount_percentage6;
				$raj_amount7 = (int)$geographicalConRajData->amount_percentage7;
				$raj_amount8 = (int)$geographicalConRajData->amount_percentage8;
				$raj_amount9 = (int)$geographicalConRajData->amount_percentage9;
			}

			foreach($productConData as $geographicalConRow)
			{
				$amount1+=$geographicalConRow->amount1;
				$amount2+=$geographicalConRow->amount2;
				$amount3+=$geographicalConRow->amount3;
				$amount4+=$geographicalConRow->amount4;
				$amount5+=$geographicalConRow->amount5;
				$amount6+=$geographicalConRow->amount6;
				$amount7+=$geographicalConRow->amount7;
				$amount8+=$geographicalConRow->amount8;
				$amount9+=$geographicalConRow->amount9;

				if($geographicalConRow->product_diversification != "Commercial Vehicle")
				{
					$other_amount1+= $geographicalConRow->amount_percentage1;
					$other_amount2+= $geographicalConRow->amount_percentage2;
					$other_amount3+= $geographicalConRow->amount_percentage3;
					$other_amount4+= $geographicalConRow->amount_percentage4;
					$other_amount5+= $geographicalConRow->amount_percentage5;
					$other_amount6+= $geographicalConRow->amount_percentage6;
					$other_amount7+= $geographicalConRow->amount_percentage7;
					$other_amount8+= $geographicalConRow->amount_percentage8;
					$other_amount9+= $geographicalConRow->amount_percentage9;
				}

				$productConTotalData = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9);
			}

			$chart2 = \Chart::title([
				'text' => 'Product Concentration',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'second_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000'
			])
			->xaxis([
				'categories' => [
					'FY16', 'FY17', 'FY18', 'FY19', 'FY20', 'H1FY21', 'FY21', 'FY22', 'FY23'
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->exporting_js(true)
			->export_data_js(true)
			/*->legend([
				'layout' => 'vertical',
		        'align' => 'right',
		        'verticalAlign' => 'middle'
			])*/
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '{y}%',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Commercial Vehicle',
						'data'  => [$raj_amount1, $raj_amount2, $raj_amount3, $raj_amount4, $raj_amount5, $raj_amount6, $raj_amount7, $raj_amount8, $raj_amount9],
					],
					[
						'showInLegend' => 'false',
						'name'  => 'Other Products',
						'data'  => [$other_amount1, $other_amount2, $other_amount3, $other_amount4, $other_amount5, $other_amount6, $other_amount7, $other_amount8, $other_amount9],
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 5)
		{
			$assetData1 = $assetData2 = $assetData3 = array();

			$assetConData1 = \DB::table('asset_quality')->where('id', "1")->where('asset_quality_status', 1)->first();
			if($assetConData1)
			{
				$assetData1 = array((float)$assetConData1->amount_percentage1, (float)$assetConData1->amount_percentage2, (float)$assetConData1->amount_percentage3, (float)$assetConData1->amount_percentage4, (float)$assetConData1->amount_percentage5, (float)$assetConData1->amount_percentage6, (float)$assetConData1->amount_percentage7, (float)$assetConData1->amount_percentage8);
			}
			$assetConData2 = \DB::table('asset_quality')->where('id', "2")->where('asset_quality_status', 1)->first();
			if($assetConData2)
			{
				$assetData2 = array((float)$assetConData2->amount_percentage1, (float)$assetConData2->amount_percentage2, (float)$assetConData2->amount_percentage3, (float)$assetConData2->amount_percentage4, (float)$assetConData2->amount_percentage5, (float)$assetConData2->amount_percentage6, (float)$assetConData2->amount_percentage7, (float)$assetConData2->amount_percentage8);
			}
			$assetConData3 = \DB::table('asset_quality')->where('id', "3")->where('asset_quality_status', 1)->first();
			if($assetConData3)
			{
				$assetData3 = array((float)$assetConData3->amount_percentage1, (float)$assetConData3->amount_percentage2, (float)$assetConData3->amount_percentage3, (float)$assetConData3->amount_percentage4, (float)$assetConData3->amount_percentage5, (float)$assetConData3->amount_percentage6, (float)$assetConData3->amount_percentage7, (float)$assetConData3->amount_percentage8);
			}

			$chart3 = \Chart::title([
				'text' => 'Asset Quality',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'third_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => [
					'FY14', 'FY15', 'FY16', 'FY17', 'FY18', 'FY19', 'FY20', 'FY21'
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->exporting_js(true)
			->export_data_js(true)
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '{y}%',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Par 150',
						'data'  => $assetData1,
					],
					[
						'showInLegend' => 'false',
						'name'  => 'Par 120',
						'data'  => $assetData2,
					],
					[
						'showInLegend' => 'false',
						'name'  => 'Par 90',
						'data'  => $assetData3,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 6)
		{
			$assetData1 = $assetData11 = $assetData2 = $assetData21 = array();

			$assetConData1 = \DB::table('collection_efficiency')->where('collection_efficiency_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $assetConRow)
				{
					$assetData1[] = (float)$assetConRow->amount_graph1;
					$assetData11[] = $assetConRow->heading_graph1;

					$assetData2[] = (float)$assetConRow->amount_graph2;
					$assetData21[] = $assetConRow->heading_graph2;
				}
			}

			$chart41 = \Chart::title([
				'text' => 'Collection Efficiency (Including Pre-payment)',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fourth1_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => $assetData11,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->exporting_js(true)
			->export_data_js(true)
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '{y}%',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Collection',
						'data'  => $assetData1,
					],
				]
			)
			->display(0);

			$chart42 = \Chart::title([
				'text' => 'Collection Efficiency (Excluding Pre-payment)',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fourth2_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => $assetData21,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
						'format' => '{y}%',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Collection',
						'data'  => $assetData2,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 8)
		{
			$assetData1 = $assetData2 = array();

			$assetConData1 = \DB::table('net_worth')->where('net_worth_status', 1)->where('particulars', 'Closing Net worth')->first();
			if($assetConData1)
			{
				$assetData1 = array((float)$assetConData1->amount1, (float)$assetConData1->amount2, (float)$assetConData1->amount3, (float)$assetConData1->amount4, (float)$assetConData1->amount5, (float)$assetConData1->amount6);
				$assetData2 = array((float)$assetConData1->amount7, (float)$assetConData1->amount8, (float)$assetConData1->amount9, (float)$assetConData1->amount10, (float)$assetConData1->amount11, (float)$assetConData1->amount12);
			}

			$chart51 = \Chart::title([
				'text' => '',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fifth1_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => ['FY17', 'FY18', 'FY19', 'FY20', 'FY21', 'H1FY21'],
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Net worth (In Cr.)',
						'data'  => $assetData1,
					],
				]
			)
			->display(0);

			$chart52 = \Chart::title([
				'text' => '',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fifth2_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => ['FY17', 'FY18', 'FY19', 'FY20', 'FY21', 'H1FY21'],
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Debt / Net worth (In Times)',
						'data'  => $assetData2,
					],
				]
			)
			->display(0);

			$netWorthData = \DB::table('net_worth_infusions')->where('net_worth_infusion_status', 1)->orderBy('id', 'DESC')->get();
			$netWorthData1 = \DB::table('net_worth')->where('net_worth_status', 1)->get();
		}
		else if($request->category_id == 9)
		{
			$liquidityData1 = $asseliquidityData2 = array();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = $amount10 = 0;
			$assetConData1 = $liquidityData = \DB::table('liquidity')->where('liquidity_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;
					$amount2+= $row->amount2;
					$amount3+= $row->amount3;
					$amount4+= $row->amount4;
					$amount5+= $row->amount5;
					$amount6+= $row->amount6;
					$amount7+= $row->amount7;
					$amount8+= $row->amount8;
					$amount9+= $row->amount9;
					$amount10+= $row->amount10;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9, 'amount10' => $amount10);

					$liquidityData1 = $liquidityDataTotal = array((float)round($amount1, 2), (float)round($amount2, 2), (float)round($amount3, 2), (float)round($amount4, 2), (float)round($amount5, 2), (float)round($amount6, 2), (float)round($amount7, 2), (float)round($amount8, 2), (float)round($amount9, 2), (float)round($amount10, 2));
				}
			}

			$chart6 = \Chart::title([
				'text' => 'Adequate Liquidity',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'sixth_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => ['Dec-18', 'Mar-19', 'Jun-19', 'Sep-19', 'Dec-19', 'Mar-20', 'Jun-20', 'Sep-20', 'Dec-20', 'Mar-21'],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
		        'align' => 'center',
		        'verticalAlign' => 'top'
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
						'enabled' => 'true',
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						'showInLegend' => 'false',
						'name'  => 'Adequate Liquidity',
						'data'  => $liquidityData1,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 12)
		{
			$amount1 = $amount2 = $amount3 = 0;
			$covidData = $covidReliefData = \DB::table('covid_relief_lenders')->where('covid_relief_lender_status', 1)->get();
			if($covidData)
			{
				foreach($covidData as $row)
				{
					$amount1+= $row->april_emi;
					$amount2+= $row->may_emi;
					$amount3+= ($row->april_emi + $row->may_emi);

					$covidReliefDataTotal = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$covidReliefDataTotal1[] = ($row->april_emi + $row->may_emi);
				}
			}

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = 0;
			$covidRelief1Data = \DB::table('covid_relief_borrowers')->where('covid_relief_borrower_status', 1)->get();
			
		}
		else if($request->category_id == 13)
		{
		}

		
		$current_year = date('Y');
		return view('insight-listing', ['insightCatData' => $insightCatData, 'insightData' => $insightData, 'insightFirst' => $insightFirst, 'geographicalConData' => $geographicalConData, 'geographicalConTotalData' => $geographicalConTotalData, 'productConData' => $productConData, 'productConTotalData' => $productConTotalData, 'chart1' => $chart1, 'chart2' => $chart2, 'chart3' => $chart3, 'chart41' => $chart41, 'chart42' =>  $chart42, 'chart51' => $chart51, 'chart52' => $chart52, 'chart6' => $chart6, 'netWorthData' => $netWorthData, 'netWorthData1' => $netWorthData1, 'liquidityData' => $liquidityData, 'liquidityDataTotal' => $liquidityDataTotal,

			'covidReliefData' => $covidReliefData, 'covidReliefDataTotal' => $covidReliefDataTotal, 'covidReliefDataTotal1' => $covidReliefDataTotal1,
			'covidRelief1Data' => $covidRelief1Data, 'covidRelief1DataTotal' => $covidRelief1DataTotal, 'covidRelief1DataTotal1' => $covidRelief1DataTotal1]);
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
						'showInLegend' => 'false',
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'showInLegend' => 'false',
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'showInLegend' => 'false',
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
						'showInLegend' => 'false',
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'showInLegend' => 'false',
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'showInLegend' => 'false',
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
						'showInLegend' => 'false',
						'name'  => $categories0,
						'data'  => $categories2,
					],
					[
						'showInLegend' => 'false',
						'name'  => $categories01,
						'data'  => $categories4,
					],
					[
						'showInLegend' => 'false',
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
						'showInLegend' => 'false',
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
						'showInLegend' => 'false',
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
		
		if(session()->get('esskay_user_id'))
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('esskay_user_id'), 'user_status' => '1'])->first();

			//dd($userRecord);
			
			$riders = array();
			return view('edit-password', ['current_user_id' => $userRecord->id, 'customer_name' => $userRecord->name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
		else if(session()->get('esskay_trustee_user_id'))
		{
			$userRecord = \DB::table('users')->where(['id' => session()->get('esskay_trustee_user_id'), 'user_status' => '1'])->first();

			//dd($userRecord);
			
			$riders = array();
			return view('edit-password', ['current_user_id' => $userRecord->id, 'customer_name' => $userRecord->name, 'title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords]);
		}
		else
		{
			return redirect(url('/'));
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
			$current_user_id = $request->current_user_id;
			$userRecord = \DB::table('users')->where(['id' => $current_user_id, 'user_status' => '1'])->first();
			
			if($userRecord)
			{
				if($userRecord->user_otp == $request->user_otp)
				{
					$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
					\DB::table('users')->where(['id' => $current_user_id])->update($updateData);

					$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
					\DB::table('lenders')->where(['user_id' => $current_user_id])->update($updateData);
					
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
				$userRecord = \DB::table('users')->where(['id' => $current_user_id, 'user_status' => '1'])->first();
			
				if($userRecord)
				{
					if($userRecord->user_otp == $request->user_otp)
					{
						$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
						\DB::table('users')->where(['id' => $current_user_id])->update($updateData);

						$updateData = array('password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s'));
						\DB::table('trustees')->where(['user_id' => $current_user_id])->update($updateData);
						
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
					
				}
				else
				{
					echo "<div class='alert alert-danger'>User not exists. Please try again.</div>";
				}
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

	// Trustee Pages
	public function insightTrustee()
    {	
    	$lenderData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($lenderData);
    	$lender_id = $lenderData->id;

		$parentData = \DB::table('insight_categories')->leftJoin('insight_category_trustee', 'insight_categories.id', '=', 'insight_category_trustee.insight_category_id')->where('insight_category_trustee.trustee_id',$lender_id)->whereNull('insight_categories.parent_id')->where('status', '1')->orderBy('insight_categories.lft', 'ASC')->get();
		//dd($parentData); 
		$parentCategoryData = array();
		
		if($parentData)
		{
			foreach($parentData as $parentRow)
			{
				$parentCategoryData[$parentRow->id] = $parentRow->name;
			}
		}
		
		return view('ess-kay-insight-trustee', ['parentCategoryData' => $parentCategoryData, 'lenderData' => $lenderData]);
	}

	// TRUSTEE
	public function showInsightTrustee(Request $request)
    {
    	Setting::assignSetting();

		//dd($request->all());
		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;
		
		$insightCatData = \DB::table('insight_categories')->where('id', '=', $request->category_id)->first();

		$insightData = \DB::table('operational_highlights')->where('operational_highlight_status', 1)->get();

		$insightFirst = \DB::table('operational_highlights')->where('operational_highlight_status', 1)->first();

		$geographicalConData = $geographicalConTotalData = array();
		$productConData = $productConTotalData = array();
		$netWorthData = $netWorthData1 = $liquidityData = $liabilityProfileData = $liabilityProfile11Data = $liabilityProfileTableData = $liabilityProfileTable11Data = array();
		$liabilityProfileDataTotal = $liquidityDataTotal = $topFiveLenders = array();

		$covidReliefData = $covidReliefDataTotal = $covidReliefDataTotal1 = array();
		$covidRelief1Data = $covidRelief1DataTotal = $covidRelief1DataTotal1 = $liabilityCategories = $liabilityCategoriesSlider = array();

		$insightLocationData = array();
		$locationCount = 0;

		$chart1 = $chart2 = $chart3 = $chart41 = $chart42 = $chart51 = $chart52 = $chart6 = $chart7 = $chart8 = $chart9 = $chart10 = array();

		if($request->category_id == 3)
		{
			$locationCount = \DB::table('insight_locations')->where('status', 1)->count();

			$geographicalConData = \DB::table('geographical_concentrations')->where('geographical_concentration_status', 1)->get();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = 0;

			$raj_amount1 = $raj_amount2 = $raj_amount3 = $raj_amount4 = $raj_amount5 = $raj_amount6 = $raj_amount7 = $raj_amount8 = $raj_amount9 = 0;
			$other_amount1 = $other_amount2 = $other_amount3 = $other_amount4 = $other_amount5 = $other_amount6 = $other_amount7 = $other_amount8 = $other_amount9 = 0;

			$geographicalConRajData = \DB::table('geographical_concentrations')->where('geographical_diversification', "Rajasthan")->where('geographical_concentration_status', 1)->first();

			if($geographicalConRajData)
			{
				$raj_amount1 = (int)$geographicalConRajData->amount_percentage1;
				$raj_amount2 = (int)$geographicalConRajData->amount_percentage2;
				$raj_amount3 = (int)$geographicalConRajData->amount_percentage3;
				$raj_amount4 = (int)$geographicalConRajData->amount_percentage4;
				$raj_amount5 = (int)$geographicalConRajData->amount_percentage5;
				$raj_amount6 = (int)$geographicalConRajData->amount_percentage6;
				$raj_amount7 = (int)$geographicalConRajData->amount_percentage7;
				$raj_amount8 = (int)$geographicalConRajData->amount_percentage8;
				$raj_amount9 = (int)$geographicalConRajData->amount_percentage9;
			}

			foreach($geographicalConData as $geographicalConRow)
			{
				$amount1+=$geographicalConRow->amount1;
				$amount2+=$geographicalConRow->amount2;
				$amount3+=$geographicalConRow->amount3;
				$amount4+=$geographicalConRow->amount4;
				$amount5+=$geographicalConRow->amount5;
				$amount6+=$geographicalConRow->amount6;
				$amount7+=$geographicalConRow->amount7;
				$amount8+=$geographicalConRow->amount8;
				$amount9+=$geographicalConRow->amount9;

				if($geographicalConRow->geographical_diversification != "Rajasthan")
				{
					$other_amount1+= $geographicalConRow->amount_percentage1;
					$other_amount2+= $geographicalConRow->amount_percentage2;
					$other_amount3+= $geographicalConRow->amount_percentage3;
					$other_amount4+= $geographicalConRow->amount_percentage4;
					$other_amount5+= $geographicalConRow->amount_percentage5;
					$other_amount6+= $geographicalConRow->amount_percentage6;
					$other_amount7+= $geographicalConRow->amount_percentage7;
					$other_amount8+= $geographicalConRow->amount_percentage8;
					$other_amount9+= $geographicalConRow->amount_percentage9;
				}

				$geographicalConTotalData = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9);
			}

			$chart1 = \Chart::title([
				'text' => ''//GEOGRAPHICAL_CONCENTRATION_HEADING
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'first_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000'
			])
			->xaxis([
				'categories' => [
					GEOGRAPHICAL_CONCENTRATION_CATEGORY
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
					'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => GEOGRAPHICAL_CONCENTRATION_LABEL1,
						'data'  => [$raj_amount1, $raj_amount2, $raj_amount3, $raj_amount4, $raj_amount5, $raj_amount6, $raj_amount7], //, , $raj_amount8$raj_amount9
					],
					[
						
						'name'  => GEOGRAPHICAL_CONCENTRATION_LABEL2,
						'data'  => [$other_amount1, $other_amount2, $other_amount3, $other_amount4, $other_amount5, $other_amount6, $other_amount7], //, , $other_amount8 $other_amount9
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 4)
		{
			$productConData = \DB::table('product_concentrations')->where('product_concentration_status', 1)->get();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = 0;

			$raj_amount1 = $raj_amount2 = $raj_amount3 = $raj_amount4 = $raj_amount5 = $raj_amount6 = $raj_amount7 = $raj_amount8 = $raj_amount9 = 0;
			$other_amount1 = $other_amount2 = $other_amount3 = $other_amount4 = $other_amount5 = $other_amount6 = $other_amount7 = $other_amount8 = $other_amount9 = 0;

			$geographicalConRajData = \DB::table('product_concentrations')->where('product_diversification', "Commercial Vehicle")->where('product_concentration_status', 1)->first();

			if($geographicalConRajData)
			{
				$raj_amount1 = (int)$geographicalConRajData->amount_percentage1;
				$raj_amount2 = (int)$geographicalConRajData->amount_percentage2;
				$raj_amount3 = (int)$geographicalConRajData->amount_percentage3;
				$raj_amount4 = (int)$geographicalConRajData->amount_percentage4;
				$raj_amount5 = (int)$geographicalConRajData->amount_percentage5;
				$raj_amount6 = (int)$geographicalConRajData->amount_percentage6;
				$raj_amount7 = (int)$geographicalConRajData->amount_percentage7;
				$raj_amount8 = (int)$geographicalConRajData->amount_percentage8;
				$raj_amount9 = (int)$geographicalConRajData->amount_percentage9;
			}

			foreach($productConData as $geographicalConRow)
			{
				$amount1+=$geographicalConRow->amount1;
				$amount2+=$geographicalConRow->amount2;
				$amount3+=$geographicalConRow->amount3;
				$amount4+=$geographicalConRow->amount4;
				$amount5+=$geographicalConRow->amount5;
				$amount6+=$geographicalConRow->amount6;
				$amount7+=$geographicalConRow->amount7;
				$amount8+=$geographicalConRow->amount8;
				$amount9+=$geographicalConRow->amount9;

				if($geographicalConRow->product_diversification != "Commercial Vehicle")
				{
					$other_amount1+= $geographicalConRow->amount_percentage1;
					$other_amount2+= $geographicalConRow->amount_percentage2;
					$other_amount3+= $geographicalConRow->amount_percentage3;
					$other_amount4+= $geographicalConRow->amount_percentage4;
					$other_amount5+= $geographicalConRow->amount_percentage5;
					$other_amount6+= $geographicalConRow->amount_percentage6;
					$other_amount7+= $geographicalConRow->amount_percentage7;
					$other_amount8+= $geographicalConRow->amount_percentage8;
					$other_amount9+= $geographicalConRow->amount_percentage9;
				}

				$productConTotalData = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9);
			}

			$chart2 = \Chart::title([
				'text' => ''//PRODUCT_CONCENTRATION_HEADING,
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'second_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000'
			])
			->xaxis([
				'categories' => [
					PRODUCT_CONCENTRATION_CATEGORY,//, 'FY22',//, 'FY23'
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => PRODUCT_CONCENTRATION_LABEL1,
						'data'  => [$raj_amount1, $raj_amount2, $raj_amount3, $raj_amount4, $raj_amount5, $raj_amount6, $raj_amount7], //, , $raj_amount8 $raj_amount9
					],
					[
						
						'name'  => PRODUCT_CONCENTRATION_LABEL2,
						'data'  => [$other_amount1, $other_amount2, $other_amount3, $other_amount4, $other_amount5, $other_amount6, $other_amount7], //, , $other_amount8 $other_amount9
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 5)
		{
			$assetData1 = $assetData2 = $assetData3 = array();

			$assetConData1 = \DB::table('asset_quality')->where('id', "1")->where('asset_quality_status', 1)->first();
			if($assetConData1)
			{
				$assetData1 = array((float)$assetConData1->amount_percentage1, (float)$assetConData1->amount_percentage2, (float)$assetConData1->amount_percentage3, (float)$assetConData1->amount_percentage4, (float)$assetConData1->amount_percentage5, (float)$assetConData1->amount_percentage6, (float)$assetConData1->amount_percentage7, (float)$assetConData1->amount_percentage8);
			}
			$assetConData2 = \DB::table('asset_quality')->where('id', "2")->where('asset_quality_status', 1)->first();
			if($assetConData2)
			{
				$assetData2 = array((float)$assetConData2->amount_percentage1, (float)$assetConData2->amount_percentage2, (float)$assetConData2->amount_percentage3, (float)$assetConData2->amount_percentage4, (float)$assetConData2->amount_percentage5, (float)$assetConData2->amount_percentage6, (float)$assetConData2->amount_percentage7, (float)$assetConData2->amount_percentage8);
			}
			$assetConData3 = \DB::table('asset_quality')->where('id', "3")->where('asset_quality_status', 1)->first();
			if($assetConData3)
			{
				$assetData3 = array((float)$assetConData3->amount_percentage1, (float)$assetConData3->amount_percentage2, (float)$assetConData3->amount_percentage3, (float)$assetConData3->amount_percentage4, (float)$assetConData3->amount_percentage5, (float)$assetConData3->amount_percentage6, (float)$assetConData3->amount_percentage7, (float)$assetConData3->amount_percentage8);
			}

			$chart3 = \Chart::title([
				'text' => ''//ASSETQUALITY_CONCENTRATION_HEADING,
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'third_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => [
					ASSETQUALITY_CONCENTRATION_CATEGORY
				],
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => ASSETQUALITY_CONCENTRATION_LABEL1,
						'data'  => $assetData1,
					],
					[
						
						'name'  => ASSETQUALITY_CONCENTRATION_LABEL2,
						'data'  => $assetData2,
					],
					[
						
						'name'  => ASSETQUALITY_CONCENTRATION_LABEL3,
						'data'  => $assetData3,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 6)
		{
			$assetData1 = $assetData11 = $assetData2 = $assetData21 = array();

			$assetConData1 = \DB::table('collection_efficiency')->where('collection_efficiency_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $assetConRow)
				{
					$assetData1[] = (float)$assetConRow->amount_graph1;
					$assetData11[] = $assetConRow->heading_graph1;

					$assetData2[] = (float)$assetConRow->amount_graph2;
					$assetData21[] = $assetConRow->heading_graph2;
				}
			}

			$chart41 = \Chart::title([
				'text' => ''//PORTFOLIOANALYSIS_HEADING
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fourth1_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => $assetData11,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => PORTFOLIOANALYSIS_LABEL1,
						'data'  => $assetData1,
					],
				]
			)
			->display(0);

			$chart42 = \Chart::title([
				'text' => ''//PORTFOLIOANALYSIS1_HEADING
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fourth2_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF', '#FF0000', '#493313'
			])
			->xaxis([
				'categories' => $assetData21,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => PORTFOLIOANALYSIS1_LABEL1,
						'data'  => $assetData2,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 8)
		{
			$assetData1 = $assetData2 = array();

			$assetConData1 = \DB::table('net_worth')->where('net_worth_status', 1)->where('particulars', 'Closing Net worth')->first();
			if($assetConData1)
			{
				$assetData1 = array((float)$assetConData1->amount1, (float)$assetConData1->amount2, (float)$assetConData1->amount3, (float)$assetConData1->amount4, (float)$assetConData1->amount5, (float)$assetConData1->amount6);
				$assetData2 = array((float)$assetConData1->amount7, (float)$assetConData1->amount8, (float)$assetConData1->amount9, (float)$assetConData1->amount10, (float)$assetConData1->amount11, (float)$assetConData1->amount12);
			}

			$chart51 = \Chart::title([
				'text' => '',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fifth1_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => [
					NETWORTH1_CATEGORY
				],
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => NETWORTH1_LABEL1,
						'data'  => $assetData1,
					],
				]
			)
			->display(0);

			$chart52 = \Chart::title([
				'text' => '',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'fifth2_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => [
					NETWORTH2_CATEGORY
				],
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => NETWORTH2_LABEL1,
						'data'  => $assetData2,
					],
				]
			)
			->display(0);

			$netWorthData = \DB::table('net_worth_infusions')->where('net_worth_infusion_status', 1)->orderBy('id', 'DESC')->get();
			$netWorthData1 = \DB::table('net_worth')->where('net_worth_status', 1)->get();
		}
		else if($request->category_id == 9)
		{
			$liquidityData1 = $asseliquidityData2 = array();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = $amount8 = $amount9 = $amount10 = 0;
			$assetConData1 = $liquidityData = \DB::table('liquidity')->where('liquidity_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;
					$amount2+= $row->amount2;
					$amount3+= $row->amount3;
					$amount4+= $row->amount4;
					$amount5+= $row->amount5;
					$amount6+= $row->amount6;
					$amount7+= $row->amount7;
					$amount8+= $row->amount8;
					$amount9+= $row->amount9;
					$amount10+= $row->amount10;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3, 'amount4' => $amount4, 'amount5' => $amount5, 'amount6' => $amount6, 'amount7' => $amount7, 'amount8' => $amount8, 'amount9' => $amount9, 'amount10' => $amount10);

					$liquidityData1 = $liquidityDataTotal = array((float)round($amount1, 2), (float)round($amount2, 2), (float)round($amount3, 2), (float)round($amount4, 2), (float)round($amount5, 2), (float)round($amount6, 2), (float)round($amount7, 2), (float)round($amount8, 2), (float)round($amount9, 2), (float)round($amount10, 2));
				}
			}

			$chart6 = \Chart::title([
				'text' => '',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'sixth_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => [
					ADEQUATE_CATEGORY
				],
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => ADEQUATE_LABEL1,
						'data'  => $liquidityData1,
					],
				]
			)
			->display(0);
		}
		else if($request->category_id == 10)
		{
			$strongLiabilityProfileData1 = $asseliquidityData2 = $profileCategory = $profileCategory1 = array();
			$liabilityProfileData1 = $liabilityProfileData2 = $liabilityProfileData3 = array();

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = 0;
			$amount1_lender = $amount2_lender = $amount3_lender = $amount4_lender = $amount5_lender = $amount6_lender = 0;

			$assetConData1 = $liabilityProfileData = \DB::table('strong_liability_profiles')->where('strong_liability_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;
					$amount2+= $row->amount2;
					$amount3+= $row->amount3;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$profileCategory[] = $profileCategory1[] = $row->quarter;

					$liabilityProfileData1[] = (int)$row->amount1;
					$liabilityProfileData2[] = (int)$row->amount2;
					$liabilityProfileData3[] = (int)$row->amount3;
				}
			}

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = $amount7 = 0;
			$amount1_lender = $amount2_lender = $amount3_lender = $amount4_lender = $amount5_lender = $amount6_lender = $amount7_lender = 0;

			$assetConData2 = $liabilityProfileTableData = \DB::table('strong_liability_profile_tables')->where('strong_liability_table_status', 1)->get();
			if($assetConData2)
			{
				foreach($assetConData2 as $row)
				{
					$amount1+= $row->amount1;
					$amount1_lender+= $row->amount1_lender;
					$amount2+= $row->amount2;
					$amount2_lender+= $row->amount2_lender;
					$amount3+= $row->amount3;
					$amount3_lender+= $row->amount3_lender;

					$amount4+= $row->amount4;
					$amount4_lender+= $row->amount4_lender;
					$amount5+= $row->amount5;
					$amount5_lender+= $row->amount5_lender;
					$amount6+= $row->amount6;
					$amount6_lender+= $row->amount6_lender;
					$amount7+= $row->amount7;
					$amount7_lender+= $row->amount7_lender;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$liabilityProfileDataTotal = array((float)round($amount1, 2), (float)round($amount1_lender, 2), (float)round($amount2, 2), (float)round($amount2_lender, 2), (float)round($amount3, 2),  (float)round($amount3_lender, 2), (float)round($amount4, 2),  (float)round($amount4_lender, 2), (float)round($amount5, 2),  (float)round($amount5_lender, 2), (float)round($amount6, 2),  (float)round($amount6_lender, 2), (float)round($amount7, 2), (float)round($amount7_lender, 2));
				}
			}

			$chart7 = \Chart::title([
				'text' => DIVERSIFIED_HEADING//'Diversified Lender Base And Access to different Pools of Capital',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'seventh_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => $profileCategory,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => DIVERSIFIED_LABEL1,
						'color' => '#11a9dc',
						'data'  => $liabilityProfileData1,
					],
					[
						
						'name'  => DIVERSIFIED_LABEL2,
						'color' => '#336699',
						'data'  => $liabilityProfileData2,
					],
					[
						
						'name'  => DIVERSIFIED_LABEL3,
						'color' => '#25a7a4',
						'data'  => $liabilityProfileData3,
					],
				]
			)
			->display(0);

			$topFiveLenders = \DB::table('lenders')->where('is_onboard', 'Onboarded')->skip(0)->take(5)->get();

			$liabilityCategories = \DB::table('liability_profile_categories')->where('status', '1')->get();

			foreach($liabilityCategories as $row)
			{
				$liabilityCategoriesSlider[$row->id] = \DB::table('liability_profile_slider')->where('liability_profile_category_id', $row->id)->where('status', '1')->get();
			}
		}
		else if($request->category_id == 11)
		{

			$profileCategory = $profileCategory1 = $liabilityProfileData11 = $liabilityProfileData12 = array();

			$amount1 = $amount2 = $amount3 = 0;
			
			$assetConData1 = $liabilityProfile11Data = \DB::table('strong_liability_profile_ratio')->where('strong_liability_ratio_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;
					$amount2+= $row->amount2;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$profileCategory[] = $profileCategory1[] = $row->financial_year;

					$liabilityProfileData11[] = (int)$row->amount1;
					$liabilityProfileData12[] = (int)$row->amount2;
				}
			}

			$chart8 = \Chart::title([
				'text' => 'Network & Employees (In Nos.)',
			])
			->chart([
				'type'     => 'column', // pie , columnt ect
				'renderTo' => 'eighth_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
				'#0000FF',
			])
			->xaxis([
				'categories' => $profileCategory1,
			])
			->yaxis([
				'title' => [
					'text' => ''
				],
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => 'Branches',
						'color' => '#336699',
						'data'  => $liabilityProfileData11,
					],
					[
						
						'name'  => 'Employee Strength',
						'color' => '#11a9dc',
						'data'  => $liabilityProfileData12,
					],
				]
			)
			->display(0);

			$profileCategory = $profileCategory1 = $liabilityProfileData11 = $liabilityProfileData12 = array();

			$amount1 = $amount2 = $amount3 = 0;
			
			$assetConData1 = $liabilityProfile11Data = \DB::table('strong_liability_profile_overall')->where('strong_liability_overall_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;

					$asseliquidityData2 = array('amount1' => $amount1);

					$profileCategory[] = $profileCategory1[] = $row->financial_year;

					$liabilityProfileData11[] = (float)$row->amount1;
				}
			}
			

			$chart10 = \Chart::title([
				'text' => DRIVINGDOWN_HEADING,//'Driving down cost of borrowings',
			])
			->chart([
				'type'     => 'line', // pie , columnt ect
				'renderTo' => 'tenth_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->xaxis([
				'categories' => $profileCategory1,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
				'stackLabels' => [
		            'enabled' => 'true',
		            'style' => [
		                'fontWeight' => 'bold',
		            ]
		        ]
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => DRIVINGDOWN_LABEL1,//'Overall cost',
						'color' => '#336699',
						'data'  => $liabilityProfileData11,
					]
				]
			)
			->display(1);

			$assetConData2 = $liabilityProfileTable11Data = \DB::table('strong_liability_profile_well_table')->where('strong_liability_well_status', 1)->get();
		}
		else if($request->category_id == 12)
		{
			$amount1 = $amount2 = $amount3 = 0;
			$covidData = $covidReliefData = \DB::table('covid_relief_lenders')->where('covid_relief_lender_status', 1)->get();
			if($covidData)
			{
				foreach($covidData as $row)
				{
					$amount1+= $row->april_emi;
					$amount2+= $row->may_emi;
					$amount3+= ($row->april_emi + $row->may_emi);

					$covidReliefDataTotal = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$covidReliefDataTotal1[] = ($row->april_emi + $row->may_emi);
				}
			}

			$amount1 = $amount2 = $amount3 = $amount4 = $amount5 = $amount6 = 0;
			$covidRelief1Data = \DB::table('covid_relief_borrowers')->where('covid_relief_borrower_status', 1)->get();
			
		}
		else if($request->category_id == 13)
		{
			$profileCategory = $profileCategory1 = $liabilityProfileData11 = $liabilityProfileData12 = array();

			$amount1 = $amount2 = $amount3 = 0;
			
			$assetConData1 = $liabilityProfile11Data = \DB::table('strong_liability_profile_driving')->where('strong_liability_driving_status', 1)->get();
			if($assetConData1)
			{
				foreach($assetConData1 as $row)
				{
					$amount1+= $row->amount1;
					$amount2+= $row->amount2;

					$asseliquidityData2 = array('amount1' => $amount1, 'amount2' => $amount2, 'amount3' => $amount3);

					$profileCategory[] = $profileCategory1[] = $row->financial_year;

					$liabilityProfileData11[] = (float)$row->amount1;
					$liabilityProfileData12[] = (float)$row->amount2;
				}
			}

			$chart9 = \Chart::title([
				'text' => ''//Healthy CRAR',
			])
			->chart([
				'type'     => 'column', // pie , columnt ect
				'renderTo' => 'ninth_chart', // render the chart into your div with id
			])
			->subtitle([
				'text' => '',
			])
			->colors([
			])
			->xaxis([
				'categories' => $profileCategory1,
			])
			->yaxis([
				'title' => [
					'text' => 'Percentage'
				],
				'stackLabels' => [
		            'enabled' => 'true',
		            'style' => [
		                'fontWeight' => 'bold',
		            ]
		        ]
			])
			->legend([
				'layout' => 'horizontal', 'verticalAlign' => 'top',
			])
			->plotOptions([
				'series'        => ([
					'dataLabels' => ([
                		'enabled' => true
                	]),
                	'label' => ([
						'enabled' => 'true',
						'format' => '',
						'connectorAllowed' => false
					]),
				]),
			])
			->credits([
				'enabled' => 'false'
			])
			->series(
				[
					[
						
						'name'  => HEALTHYCRAR_LABEL1,//'Tier1',
						'color' => '#336699',
						'data'  => $liabilityProfileData11,
					],
					[
						
						'name'  => HEALTHYCRAR_LABEL2,//'Tier2',
						'color' => '#11a9dc',
						'data'  => $liabilityProfileData12,
					],
				]
			)
			->display(1);
		}
		else if($request->category_id == 14)
		{
			$insightLocationData = \DB::table('insight_locations')->leftJoin('districts', 'insight_locations.district_id', '=', 'districts.id')->leftJoin('states', 'districts.state_id', '=', 'states.id')->where('insight_locations.status', 1)->selectRaw('location_hub, branch_name, branch_type, branch_address, office_lat, office_long, insight_locations.lft, states.name as state_name, districts.name as district_name')->get();
		}

		//dd($liabilityProfileDataTotal);

		
		$current_year = date('Y');
		return view('insight-listing-trustee', ['insightCatData' => $insightCatData, 'insightData' => $insightData, 'insightFirst' => $insightFirst, 'geographicalConData' => $geographicalConData, 'geographicalConTotalData' => $geographicalConTotalData, 'productConData' => $productConData, 'productConTotalData' => $productConTotalData, 'chart1' => $chart1, 'chart2' => $chart2, 'chart3' => $chart3, 'chart41' => $chart41, 'chart42' =>  $chart42, 'chart51' => $chart51, 'chart52' => $chart52, 'chart6' => $chart6, 'chart7' => $chart7, 'chart8' => $chart8, 'chart9' => $chart9, 'chart10' => $chart10, 'netWorthData' => $netWorthData, 'netWorthData1' => $netWorthData1, 'liquidityData' => $liquidityData, 'liquidityDataTotal' => $liquidityDataTotal,

			'insightLocationData' => $insightLocationData,
			'liabilityCategories' => $liabilityCategories,
			'liabilityCategoriesSlider' => $liabilityCategoriesSlider,
			'locationCount' => $locationCount,
			'liabilityProfileData' => $liabilityProfileData,
			'liabilityProfileTableData' => $liabilityProfileTableData,
			'liabilityProfileTable11Data' => $liabilityProfileTable11Data,
			'liabilityProfileDataTotal' => $liabilityProfileDataTotal,
			'topFiveLenders' => $topFiveLenders,

			'covidReliefData' => $covidReliefData, 'covidReliefDataTotal' => $covidReliefDataTotal, 'covidReliefDataTotal1' => $covidReliefDataTotal1,
			'covidRelief1Data' => $covidRelief1Data, 'covidRelief1DataTotal' => $covidRelief1DataTotal, 'covidRelief1DataTotal1' => $covidRelief1DataTotal1]);
	}

	public function sanctionLetterTrustee()
    {
    	$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$sanctionData = \DB::table('sanction_letters')->where('status', '1')->get();
		
		return view('ess-kay-sanction-letter', ['sanctionData' => $sanctionData, 'lenderData' => $trusteeData]);
	}


	public function dealTrustee()
	{
		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_trustee', 'current_deal_category_trustee.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_trustee.trustee_id',$trustee_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name, current_deal_categories.category_name')->get();
		
		return view('ess-kay-deal-trustee', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'trusteeData' => $trusteeData]);
	}

	// Search
	public function dealSearchTrustee(Request $request)
	{
		$deal_filterby = $request->deal_filterby;
		$deal_rating = $request->deal_rating;
		$category_name = $request->category_name;

		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_trustee', 'current_deal_category_trustee.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_trustee.trustee_id',$trustee_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();

		if($deal_filterby != "")
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();
			}
			else
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();
			}
		}
		else
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();
			}
		}
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'trusteeData' => $trusteeData]);
	}
	

	// Sort
	public function dealSortTrustee(Request $request)
	{
		$sort_value = $request->sort_value;

		$deal_filterby = $request->deal_filterby;
		$deal_rating = $request->deal_rating;

		$category_name = $request->category_name;

		$sortData = explode("-", $sort_value);

		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_trustee', 'current_deal_category_trustee.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_trustee.trustee_id',$trustee_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();

		if($deal_filterby != "")
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
			else
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		else
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'trusteeData' => $trusteeData]);
	}

	public function dealGridTrustee(Request $request)
	{
		$sort_value = $request->sort_value;

		$deal_filterby = $request->deal_filterby;
		$deal_rating = $request->deal_rating;

		$category_name = $request->category_name;

		if($sort_value == "")
		{
			$sort_value = "current_deals.created_at-desc";
		}
		$sortData = explode("-", $sort_value);

		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_trustee', 'current_deal_category_trustee.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_trustee.trustee_id',$trustee_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();

		if($deal_filterby != "")
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
			else
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		else
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		
		return view('ess-kay-deal-grid', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'trusteeData' => $trusteeData]);
	}

	public function dealListTrustee(Request $request)
	{
		$sort_value = $request->sort_value;

		$deal_filterby = $request->deal_filterby;
		$deal_rating = $request->deal_rating;

		$category_name = $request->category_name;

		if($sort_value == "")
		{
			$sort_value = "current_deals.created_at-desc";
		}
		$sortData = explode("-", $sort_value);

		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$dealTotalData = \DB::table('current_deals')->selectRaw('count(id) as total, SUM(amount) as total_amount')->where('status', '1')->first();

		$dealCategoriesData = \DB::table('current_deal_categories')->leftJoin('current_deal_category_trustee', 'current_deal_category_trustee.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deal_category_trustee.trustee_id',$trustee_id)->where('status', '1')->get();

		$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->get();

		if($deal_filterby != "")
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
			else
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.name', 'LIKE', '%'.$deal_filterby.'%')->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		else
		{
			if($deal_rating != "")
			{
				$dealsData = \DB::table('current_deals')->leftJoin('current_deal_categories', 'current_deals.current_deal_category_id', '=', 'current_deal_categories.id')->where('current_deals.status', '1')->where('current_deal_categories.status', '1')->where('current_deals.rating', $deal_rating)->selectRaw('current_deals.*, current_deal_categories.category_code, current_deal_categories.category_name')->orderBy($sortData[0], $sortData[1])->get();
			}
		}
		
		return view('ess-kay-deal-list', ['dealTotalData' => $dealTotalData, 'dealsData' => $dealsData, 'dealCategoriesData' => $dealCategoriesData, 'category_name' => $category_name, 'trusteeData' => $trusteeData]);
	}

	public function newsTrustee()
    {	
		$customer_name = session()->get('esskay_trustee_verify');
		
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
		
		return view('ess-kay-news-trustee', ['customer_name' => $customer_name, 'articleData' => $articleData, 'categoriesData' => $categoriesData]);
		
	}
	
	public function contactUsTrustee()
    {	
		$pageInfo = Page::getPageInfo(2);
		
		$customer_name = session()->get('esskay_trustee_verify');
		
		Setting::assignSetting();
		
		return view('ess-kay-contact-trustee', ['customer_name' => $customer_name, 'page_title' => $pageInfo->title, 'page_content' => $pageInfo->content]);
	}

	public function documentTrustee()
    {	
    	$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;

		$parentData = \DB::table('document_category')->leftJoin('document_category_trustee', 'document_category.id', '=', 'document_category_trustee.document_category_id')->where('document_category_trustee.trustee_id',$trustee_id)->whereNull('document_category.parent_id')->orderBy('document_category.lft', 'ASC')->get();
		//dd($parentData); 
		$parentCategoryData = $childCategoryData = $childChildCategoryData = array();
		
		if($parentData)
		{
			foreach($parentData as $parentRow)
			{
				$parentCategoryData[$parentRow->id] = array('name' => $parentRow->name, 'image' => url('/')."/".$parentRow->category_image);
				
				//$childData = \DB::table('document_category')->where('parent_id', $parentRow->id)->orderBy('lft', 'ASC')->get();
				$childData = \DB::table('document_category')->leftJoin('document_category_trustee', 'document_category.id', '=', 'document_category_trustee.document_category_id')->where('document_category_trustee.trustee_id',$trustee_id)->where('document_category.parent_id', $parentRow->id)->orderBy('document_category.lft', 'ASC')->get();
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
		
		return view('ess-kay-document-trustee', ['documentDateData' => $document_date, 'parentCategoryData' => $parentCategoryData, 'childCategoryData' => $childCategoryData, 'childChildCategoryData' => $childChildCategoryData, 'trusteeData' => $trusteeData, 'current_year' => $current_year]);
	}

	public function showDocTrustee(Request $request)
    {
		//dd($request->all());
		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;
    	
		$parentData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();
		$is_timeline = 0;
		if($parentData)
		{
			$is_timeline = $parentData->is_timeline;
		}
		
		//echo $request->document_date;
		
		if($is_timeline)
		{
			$docData = \DB::table('documents')->leftJoin('document_trustee', 'documents.id', '=', 'document_trustee.document_id')->where('document_trustee.trustee_id',$trustee_id)->where('documents.document_category_id', '=', $request->category_id)->orWhere('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_trustee.document_id')->get();
		}
		else
		{
			$docData = \DB::table('documents')->leftJoin('document_trustee', 'documents.id', '=', 'document_trustee.document_id')->where('document_trustee.trustee_id',$trustee_id)->where('documents.document_category_id', '=', $request->category_id)->orWhere('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_trustee.document_id')->get();
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
					else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
		return view('document-file-trustee', ['documentDateData' => $document_date, 'docu_date' => $request->document_date, 'cat_name' => $cat_name, 'category_name' => $category_name, 'subCategory' => $subCategoryArr, 'is_timeline' => $is_timeline, 'docData' => $docArr, 'esskay_doc_date' => session()->get('esskay_doc_date'), 'current_year' => $current_year, 'category_id' => $request->category_id]);
	}

	public function showChildDocTrustee(Request $request)
    {
		//dd($request->all());
		$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
    	//dd($trusteeData);
    	$trustee_id = $trusteeData->id;
		
		$parentData = \DB::table('document_category')->where('id', '=', $request->category_id)->first();
		$is_timeline = 0;
		if($parentData)
		{
			$is_timeline = $parentData->is_timeline;
		}
		
		//echo $request->document_date;
		
		if($is_timeline)
		{
			$docData = \DB::table('documents')->leftJoin('document_trustee', 'documents.id', '=', 'document_trustee.document_id')->where('document_trustee.trustee_id',$trustee_id)->where('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_trustee.document_id')->get();
		}
		else
		{
			$docData = \DB::table('documents')->leftJoin('document_trustee', 'documents.id', '=', 'document_trustee.document_id')->where('document_trustee.trustee_id',$trustee_id)->where('documents.document_sub_category_id', '=', $request->category_id)->groupBy('document_trustee.document_id')->get();
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
					else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
						else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
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
		
		return view('document-child-file-trustee', ['documentDateData' => $document_date, 'docu_date' => $request->document_date, 'cat_name' => $cat_name, 'category_name' => $category_name, 'subCategory' => $subCategoryArr, 'category_id' => $request->category_id, 'is_timeline' => $is_timeline, 'docData' => $docArr, 'esskay_doc_date' => session()->get('esskay_doc_date')]);
	}

	// Download Trans Doc
	public function previewTransDocTrustee($doc_id)
    {
    	$customer_name = session()->get('esskay_trustee_verify');

		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			// Download file
			$doc_id = base64_decode($doc_id);
			$docData  = \DB::table('transaction_documents')->where('id', '=', $doc_id)->first();
			//dd($docData);

			
			if($docData)
			{
				$file = asset('/'). $docData->document_filename;
				
				header('location:'.$file);
			}
		}
	}
	

	public function previewDocTrustee($doc_id)
    {
    	$customer_name = session()->get('esskay_trustee_verify');

		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
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
	}
	
	public function downloadFileTrustee($doc_id)
    {	
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			$docData  = \DB::table('articles')->where('id', '=', $doc_id)->first();
			
			$file= public_path(). "/".$docData->article_pdf;
			
			/*$headers = array(
					  'Content-Type: application/pdf',
					);*/
					
			$article_pdf = explode("/", $docData->article_pdf);
			$doc = array_pop($article_pdf);

			\DB::table('user_pdf')->insert(['user_id' => session()->get('esskay_trustee_user_id'), 'article_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			
			return response()->download($file, $doc);
		}
	}

	// Download trans Doc
	public function downloadTransDocTrustee($doc_id)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			// Download file
			$doc_id = base64_decode($doc_id);
			$docData  = \DB::table('transaction_documents')->where('id', '=', $doc_id)->first();
			
			if($docData)
			{
				$file= public_path(). "/".$docData->document_filename;
				
				/*$headers = array(
						  'Content-Type: application/pdf',
						);*/
						
				$document_filename = explode("/", $docData->document_filename);
				$doc = array_pop($document_filename);

				\DB::table('user_transaction_document')->insert(['user_id' => session()->get('esskay_trustee_user_id'), 'transaction_document_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				
				return response()->download($file, $doc);
			}
		}
	}

	public function downloadDocTrustee($doc_id)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			// Download file
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

				\DB::table('user_document')->insert(['user_id' => session()->get('esskay_trustee_user_id'), 'document_id' => $doc_id, 'download_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				
				return response()->download($file, $doc);
			}
		}
	}

	public function transactionCategory($category_id)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
	    	//dd($trusteeData);
	    	$trustee_id = $trusteeData->id;

	    	$categoryData = \DB::table('transaction_categories')->leftJoin('transaction_category_trustee', 'transaction_categories.id', '=', 'transaction_category_trustee.transaction_category_id')->where('transaction_category_trustee.trustee_id',$trustee_id)->where('transaction_categories.id',$category_id)->groupBy('transaction_category_trustee.transaction_category_id')->first();

	    	if($categoryData)
	    	{
	    		$transactionLiveData = \DB::table('transactions')->leftJoin('transaction_trustee', 'transactions.id', '=', 'transaction_trustee.transaction_id')->where('transaction_trustee.trustee_id',$trustee_id)->where('transactions.transaction_category_id',$category_id)->where('transaction_type', 'Live')->groupBy('transaction_trustee.transaction_id')->get();

	    		$transactionMaturedData = \DB::table('transactions')->leftJoin('transaction_trustee', 'transactions.id', '=', 'transaction_trustee.transaction_id')->where('transaction_trustee.trustee_id',$trustee_id)->where('transactions.transaction_category_id',$category_id)->where('transaction_type', 'Matured')->groupBy('transaction_trustee.transaction_id')->get();

	    		return view('transaction-category-trustee', ['trustee_id' => $trustee_id, 'category_id' => $category_id, 'categoryData' => $categoryData, 'transactionLiveData' => $transactionLiveData, 'transactionMaturedData' => $transactionMaturedData]);
	    	}
	    	else
	    	{
	    		echo 'Data not exists.';
	    	}
	    }
    }

    public function showTrusteeTransactionInfo(Request $request)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			//dd($request->all());
			$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
	    	//dd($trusteeData);
	    	$trustee_id = $trusteeData->id;

	    	$transaction_id = $request->transaction_id;
	    	$transaction_category_id = $request->transaction_category_id;

	    	$transactionData = \DB::table('transactions')->leftJoin('transaction_trustee', 'transactions.id', '=', 'transaction_trustee.transaction_id')->where('transaction_trustee.trustee_id',$trustee_id)->where('transactions.id',$transaction_id)->groupBy('transaction_trustee.transaction_id')->first();

	    	if($transactionData)
	    	{
	    		$categoryData = \DB::table('transaction_categories')->leftJoin('transaction_category_trustee', 'transaction_categories.id', '=', 'transaction_category_trustee.transaction_category_id')->where('transaction_category_trustee.trustee_id',$trustee_id)->where('transaction_categories.id',$transactionData->transaction_category_id)->groupBy('transaction_category_trustee.transaction_category_id')->first();

	    		$document_date = array();
				for($count=date('Y');$count>=2015;$count--)
				{
					$document_date[$count] = $count;
				}
				$docu_date = date('Y');

	    		return view('transaction-category-trustee-info', ['trustee_id' => $trustee_id, 'transaction_category_id' => $transaction_category_id, 'categoryData' => $categoryData, 'transactionData' => $transactionData, 'document_date' => $document_date, 'docu_date' => $docu_date, 'transaction_id' => $transaction_id]);
	    	}
	    }
    }

    public function assignTransactionDate(Request $request)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			$docu_date = $request->dateVal;

			session ( [
				'esskay_transaction_doc_date' => $docu_date
			] );
		}
	}


    public function showTrusteeTransactionDocumentInfo(Request $request)
    {
    	// Download file
    	$customer_name = session()->get('esskay_trustee_verify');
		
		if(!$customer_name)
		{
			return redirect(url('/').'/login');
		}
		else
		{
			//dd($request->all());
			$trusteeData = \DB::table('trustees')->where('user_id', session()->get('esskay_trustee_user_id'))->first();
	    	//dd($trusteeData);
	    	$trustee_id = $trusteeData->id;

	    	$transaction_id = $request->transaction_id;
	    	$report_type = $request->report_type;

	    	$transactionData = \DB::table('transactions')->leftJoin('transaction_trustee', 'transactions.id', '=', 'transaction_trustee.transaction_id')->where('transaction_trustee.trustee_id',$trustee_id)->where('transactions.id',$transaction_id)->groupBy('transaction_trustee.transaction_id')->first();

	    	if($transactionData)
	    	{
	    		$categoryData = \DB::table('transaction_categories')->leftJoin('transaction_category_trustee', 'transaction_categories.id', '=', 'transaction_category_trustee.transaction_category_id')->where('transaction_category_trustee.trustee_id',$trustee_id)->where('transaction_categories.id',$transactionData->transaction_category_id)->groupBy('transaction_category_trustee.transaction_category_id')->first();

	    		$document_date = array();
				for($count=date('Y');$count>=2015;$count--)
				{
					$document_date[$count] = $count;
				}

				$sesssion_doc_date = session()->get('esskay_transaction_doc_date');

				if(!$sesssion_doc_date)
				{
					$docu_date = date('Y');

					session ( [
						'esskay_transaction_doc_date' => $docu_date
					] );
				}
				else
				{
					$docu_date = session()->get('esskay_transaction_doc_date');
				}

				$termSheetDocData = $serviceAgreementDocData = $accountAgreementDocData = $assignmentAgreementDocData = $trustDeedDocData = $imDocData = $anyotherDocData = array();

				$monthlyJanDocData = $monthlyFebDocData = $monthlyMarDocData = $monthlyAprDocData = $monthlyMayDocData = $monthlyJuneDocData = $monthlyJulyDocData = $monthlyAugDocData = $monthlySepDocData = $monthlyOctDocData = $monthlyNovDocData = $monthlyDecDocData = array();

				if($report_type == 1)
				{
					$termSheetDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Executed Report')->selectRaw('transaction_documents.*,transactions.name')->where('document_status', '1')->where('transaction_id',$transaction_id)->get(); //->where('transaction_document_type_id', '1')

					if($termSheetDoc)
					{
						foreach($termSheetDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();
							
							if($row->transaction_document_type_id == 1)
							{
								$termSheetDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);	
							}
							else if($row->transaction_document_type_id == 2)
							{
								$serviceAgreementDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
							else if($row->transaction_document_type_id == 3)
							{
								$accountAgreementDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
							else if($row->transaction_document_type_id == 4)
							{
								$assignmentAgreementDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
							else if($row->transaction_document_type_id == 5)
							{
								$trustDeedDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
							else if($row->transaction_document_type_id == 6)
							{
								$imDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
							else if($row->transaction_document_type_id == 7)
							{
								$anyotherDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
							}
						}
					}
				}
				else if($report_type == 2)
				{
					$monthlyJanDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '1')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyJanDoc)
					{
						foreach($monthlyJanDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyJanDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyFebDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '2')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyFebDoc)
					{
						foreach($monthlyFebDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyFebDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyMarDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '3')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyMarDoc)
					{
						foreach($monthlyMarDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyMarDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyAprDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '4')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyAprDoc)
					{
						foreach($monthlyAprDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyAprDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyMayDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '5')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyMayDoc)
					{
						foreach($monthlyMayDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyMayDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyJuneDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '6')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyJuneDoc)
					{
						foreach($monthlyJuneDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyJuneDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyJulyDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '7')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyJulyDoc)
					{
						foreach($monthlyJulyDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyJulyDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyAugDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '8')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyAugDoc)
					{
						foreach($monthlyAugDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyAugDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlySepDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '9')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlySepDoc)
					{
						foreach($monthlySepDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlySepDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyOctDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '10')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyOctDoc)
					{
						foreach($monthlyOctDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyOctDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyNovDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '11')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyNovDoc)
					{
						foreach($monthlyNovDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyNovDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}

					$monthlyDecDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Monthly Payout Report')->where('document_date', $docu_date)->whereYear('expiry_date', $docu_date)->whereMonth('expiry_date', '12')->selectRaw('transaction_documents.*,transactions.name')->where('transaction_id',$transaction_id)->get();

					if($monthlyDecDoc)
					{
						foreach($monthlyDecDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();

							$monthlyDecDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);
						}
					}
				}
				else if($report_type == 5)
				{
					$termSheetDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Charge Creation')->selectRaw('transaction_documents.*,transactions.name')->where('document_status', '1')->where('transaction_id',$transaction_id)->get(); //->where('transaction_document_type_id', '1')

					if($termSheetDoc)
					{
						foreach($termSheetDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();
							
							if($row->transaction_document_type_id == 8)
							{
								$termSheetDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);	
							}
						}
					}
				}
				else if($report_type == 6)
				{
					$termSheetDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Satisfaction of Charge')->selectRaw('transaction_documents.*,transactions.name')->where('document_status', '1')->where('transaction_id',$transaction_id)->get(); //->where('transaction_document_type_id', '1')

					if($termSheetDoc)
					{
						foreach($termSheetDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();
							
							if($row->transaction_document_type_id == 10)
							{
								$termSheetDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);	
							}
						}
					}
				}
				else if($report_type == 7)
				{
					$termSheetDoc = \DB::table('transaction_documents')->leftJoin('transactions', 'transaction_documents.transaction_id', '=', 'transactions.id')->where('document_type', 'Charge Creation1')->selectRaw('transaction_documents.*,transactions.name')->where('document_status', '1')->where('transaction_id',$transaction_id)->get(); //->where('transaction_document_type_id', '1')

					if($termSheetDoc)
					{
						foreach($termSheetDoc as $row)
						{
							$ext = pathinfo($row->document_filename, PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
							{
								$ext = "picture";
							}
							else if($ext == "xls" || $ext == "xlsx" || $ext == "xlsb")
							{
								$ext = "excel";
							}
							else if($ext == "doc" || $ext == "docx")
							{
								$ext = "word";
							}

							$doc_download = \DB::table('user_transaction_document')->where('transaction_document_id', '=', $row->id)->where('user_id', '=', session()->get('esskay_trustee_user_id'))->count();
							
							if($row->transaction_document_type_id == 9)
							{
								$termSheetDocData[] = array('id' => $row->id, 'document_name' => $row->document_name, 'expiry_date' => $row->expiry_date, 'ext' => $ext, 'doc_download' => $doc_download);	
							}
						}
					}
				}

				//dd($monthlyDecDocData);

				$heading_title = "";

				if($report_type == 1)
				{
					$heading_title = "Executed Report";
				}
				else if($report_type == 2)
				{
					$heading_title = "Monthly Payout Report";
				}
				else if($report_type == 3)
				{
					$heading_title = "Collection Efficiency";
				}
				else if($report_type == 4)
				{
					$heading_title = "Pool Dynamics";
				}
				else if($report_type == 5)
				{
					$heading_title = "Charge Creation / Modification";
				}
				else if($report_type == 6)
				{
					$heading_title = "Satisfaction of Charge";
				}
				else if($report_type == 7)
				{
					$heading_title = "Charge Creation / Modification";
				}


	    		return view('transaction-category-trustee-info-document', ['trustee_id' => $trustee_id, 'categoryData' => $categoryData, 'transactionData' => $transactionData, 'document_date' => $document_date, 'docu_date' => $docu_date, 'transaction_id' => $transaction_id, 'report_type' => $report_type, 'heading_title' => $heading_title,

	    			'termSheetDocData' => $termSheetDocData, 'serviceAgreementDocData' => $serviceAgreementDocData, 'accountAgreementDocData' => $accountAgreementDocData, 'assignmentAgreementDocData' => $assignmentAgreementDocData, 'trustDeedDocData' => $trustDeedDocData, 'imDocData' => $imDocData, 'anyotherDocData' => $anyotherDocData,

	    			'monthlyJanDocData' => $monthlyJanDocData, 'monthlyFebDocData' => $monthlyFebDocData, 'monthlyMarDocData' => $monthlyMarDocData, 'monthlyAprDocData' => $monthlyAprDocData, 'monthlyMayDocData' => $monthlyMayDocData, 'monthlyJuneDocData' => $monthlyJuneDocData, 'monthlyJulyDocData' => $monthlyJulyDocData, 'monthlyAugDocData' => $monthlyAugDocData, 'monthlySepDocData' => $monthlySepDocData, 'monthlyOctDocData' => $monthlyOctDocData, 'monthlyNovDocData' => $monthlyNovDocData, 'monthlyDecDocData' => $monthlyDecDocData 

	    		]);
	    	}
	    }
    }
}
