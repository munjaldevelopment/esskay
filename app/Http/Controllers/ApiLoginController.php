<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Session;
use Redirect;
use Request;
use DB;
use App\Models\Setting;
use App\User;

class ApiLoginController extends Controller
{
	
	public function vibsLogin()
    {
		$request = Request::instance();

		// Now we can get the content from it
		$content = $request->getContent();

        $jsonData = json_decode($content);
		
		$token = $jsonData->data->token;
		
		//echo $token; exit;
		
		
		$userToken= $token;
        $projectId = '5e730afe6b5a6d2bbc75ec49';
        $projectSecret = 'kdJsJHdSwjkkdDH';
        
        $data = ['token'=> $token];
        $string = $projectId.'|'.json_encode($data).'|'.$projectSecret;

        $hash= hash('sha256',($string));
        $cbitString2= ['data'=>$data,'project'=>$projectId, 'hash'=>$hash];
        $cbitRequest2= json_encode($cbitString2);
        $ch2 = curl_init();
        $curlConfig = array(
        CURLOPT_URL            => "http://3.6.197.213/api/v1/user/view-profile",
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     =>  array('Content-Type: application/json', 'Content-Length: ' . strlen($cbitRequest2)),
        CURLOPT_POSTFIELDS     => $cbitRequest2
        );
        curl_setopt_array($ch2, $curlConfig);
        $response2 = curl_exec($ch2);
        curl_close($ch2);
        $decodeResponse2 = json_decode($response2);
        //echo '<pre>'; print_r($decodeResponse2); exit;
		
        if($decodeResponse2->status==1)
        {
            $id = $decodeResponse2->data->user_id;
            $email_id = $decodeResponse2->data->email_id;
            $name = $decodeResponse2->data->user_full_name;
            $mobile = $decodeResponse2->data->mobile_no;
			
            $checkRecord = DB::table('users')->where(['email' => $email_id])->orWhere(['mobile' => $mobile])->first();

            if($checkRecord)
            {
                $password = '12345678';
               
                $id =  DB::table('users')->where(['email' => $email_id])->update([
                    'password' => Hash::make($password)
                ]);
				
				$user_id = $checkRecord->id;

                if (Auth::attempt(array(
                    'email' => $email_id,
                    'password' => $password,
                ))) 
                {
                    $status_code = '1';
                    $message = 'Logged In sucessfully';
                }
                else
                {
                    $status_code = '0';
                    $message = 'Invalid Credentials';
                }
            }else{
               $password = '12345678';
			   
			   $now = \Carbon\Carbon::now();
               
               $id =  DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $email_id,
                    'mobile' => $mobile,
                    'status' => '1',
                    'password' => Hash::make($password),
					'remember_token' => str_random(10),
					'created_at'     => $now,
					'updated_at'     => $now,
                ]);
				
				$user_id = $id;
				
				/*DB::table('model_has_roles')->insert([
                    'role_id' => '1',
                    'model_id' => $user_id,
                    'model_type' => 'App\Models\BackpackUser'
                ]);*/
				
				DB::table('model_has_roles')->insert([
                    'role_id' => '3',
                    'model_id' => $user_id,
                    'model_type' => 'App\Models\BackpackUser'
                ]);

				if (Auth::attempt(array(
                    'email' => $email_id,
                    'password' => $password,
                ))) 
                {
                    $status_code = '1';
                    $message = 'Logged In sucessfully';
                }
                else
                {
                    $status_code = '0';
                    $message = 'Invalid Credentials';
                }
            }
			
			$user = User::findOrFail($user_id);
			backpack_auth()->login($user);
			
			$json = array('status' => true, 'url' => backpack_url('dashboard'));
        }else{
			$json = array('status' => false, 'url' => '');
        }
		
		return response()->json($json, 200);
    }
}
