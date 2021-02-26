<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Hash;
use URL;
use File;
use Session;
use QR_Code\QR_Code;

class apiController extends Controller
{
    //START LOGIN
	public function customerLogin($mobile,$device_id)
    {
        try 
        {
            $json = $userData = array();
            $mobile = $mobile;
            $date   = date('Y-m-d H:i:s');
            $customer = DB::table('customers')->where('telephone', $mobile)->first();
            if($customer) 
            {
                
                $customerid = $customer->id;
                $deviceid = $customer->device_id;
                
                if($device_id == $deviceid){
                    $status_code = '1';
                    $message = 'Customer login succesfully';
                    $json = array('status_code' => $status_code, 'message' => $message, 'mobile' => $mobile);
                }else{    
                    $otp = rand(111111, 999999);
                    $smsmessage = str_replace(" ", "%20", "Your OTP is ".$otp);
     
                    //$this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=avani&password=avani&senderid=AVANIE&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$message."&route=15");
                    
                 

                    DB::table('customers')->where('id', '=', $customerid)->update(['otp' => $otp, 'device_id' => $device_id, 'updated_at' => $date]);

                    $status_code = '1';
                    $message = 'Customer Otp Send, Please Process Next Step';
                    $json = array('status_code' => $status_code, 'message' => $message, 'mobile' => $mobile, 'otp' => $otp);
                }
            }else{

                $otp = rand(111111, 999999);
                $smsmessage = str_replace(" ", "%20", "Your OTP is ".$otp);
 
                //$this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=avani&password=avani&senderid=AVANIE&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$message."&route=15");
                //$device_id = 'WER34#$@efd';

                DB::table('customers')->insert(['telephone' => $mobile, 'otp' => $otp, 'device_id' => $device_id, 'created_at' => $date, 'updated_at' => $date]); 

                $status_code = $success = '1';
                $message = 'Customer Otp Send, Please Process Next Step';
                $json = array('status_code' => $status_code, 'message' => $message, 'mobile' => $mobile, 'otp' => $otp);
           }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message);
        }
    
        return response()->json($json, 200);
    }
    // End Login
    

    public function httpGet($url)
    {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch);
        return $head;
    }

    //START VERIFY
    public function customerVerify($mobile,$otp)
    {
        try 
        {
            $json = $userData = array();
            $mobile = $mobile;
            $otp = $otp;
            $customer = DB::table('customers')->where('telephone', $mobile)->where('otp', $otp)->first();
            if($customer) 
            {
                DB::table('customers')->where(['id' => $customer->id])->update(['status' => 1]);
                $customerData= DB::table('customers')->where('id', $customer->id)->first();
                    
                $status_code = '1';
                $message = 'Customer activated sucessfully';
                $json = array('status_code' => $status_code,  'message' => $message, 'customer_id' => (int)$customerData->id, 'mobile' => $mobile);
            } 
            else 
            {
                $status_code = $success = '0';
                $message = 'Sorry! Customer does not exists or Incorrect OTP!';
                
                $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => '', 'mobile' => $mobile);
           }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => '');
        }
        
        return response()->json($json, 200);
    }
    
    //START VERIFY
    public function resendSMS($mobile)
    {
        try 
        {
            $json = $userData = array();
            $mobile = $mobile;
            $customer = DB::table('customers')->where('telephone', $mobile)->first();
            if($customer) 
            {
                $customerid = $customer->id;
                $otp = rand(111111, 999999);
                $smsmessage = str_replace(" ", "%20", "Your OTP is ".$otp);
 
                //$this->httpGet("http://opensms.microprixs.com/api/mt/SendSMS?user=avani&password=avani&senderid=AVANIE&channel=trans&DCS=0&flashsms=0&number=".$mobile."&text=".$message."&route=15");
                //$device_id = 'WER34#$@efd';

                 DB::table('customers')->where('id', '=', $customerid)->update(['otp' => $otp, 'updated_at' => $date]);

                $status_code = '1';
                $message = 'OTP Send sucessfully';
                $json = array('status_code' => $status_code,  'message' => $message, 'customer_id' => (int)$customerid,  'mobile' => $mobile, 'otp' => $otp);
            } 
            else 
            {
                $status_code = $success = '0';
                $message = 'Sorry! Customer does not exists';
                
                $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => '', 'mobile' => $mobile);
           }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => '');
        }
        
        return response()->json($json, 200);
    }

    //Customer Update
    public function customerstep3(Request $request)
    {
        try 
        {
            $json = $userData = array();
            $bodyContent = $request->all();
             $date   = date('Y-m-d H:i:s');
            $customer_id = $bodyContent['customer_id'];
            $name = $bodyContent['name'];
            $age = $bodyContent['age'];
            $customer = DB::table('customers')->where('id', $customer_id)->first();
            if($customer){ 
                
                DB::table('customers')->where('id', '=', $customer_id)->update(['name' => $name, 'age' => $age, 'updated_at' => $date]);

                $status_code = $success = '1';
                $message = 'Customer info added succesfully';
                
                $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => $customer_id, 'bodyContent' => $bodyContent);


            } else{
                $status_code = $success = '0';
                $message = 'Customer not valid';
                
                $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => $customer_id, 'bodyContent' => $bodyContent);
            }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message, 'customer_id' => '');
        }
        
        return response()->json($json, 200);
    }


    //START show feed list 
    public function feedList($language)
    {
        try 
        {   
            $baseUrl = URL::to("/");
            $json       =   array();
            //$user_id    =   $request->user_id;
            //$role_id    =   $request->role_id;
            //$is_emp     =   (int)$request->is_emp;
        
			// 2 = process one, 3 = process two, 4 = process three, 5= process four, 6 = process complete, 9 = planning
			//echo $role_id; exit;
			
            $feedList = array();
            $rsfeeds = DB::table('feeds')->where('language', $language)->where('status', '=', 'PUBLISHED')->orderBy('id', 'DESC')->get();
			
            if(count($rsfeeds) >0)
            {
                foreach($rsfeeds as $showFeed)
                {
					$feedimage  =  $baseUrl."/".$showFeed->image;
					$feedList[] = ['id' => (int)$showFeed->id, 'title' =>$showFeed->title, 'content' =>$showFeed->content, 'date' => $showFeed->date, 'feedimage' => $feedimage]; //'planning_isprogress' => $planning_isprogress, 
                }

                $status_code = '1';
                $message = 'Show feed list';
                $json = array('status_code' => $status_code,  'message' => $message, 'processList' => $feedList);
            }
            else
            {
                $status_code = '0';
                $message = 'Sorry! no feed exists .';
                $json = array('status_code' => $status_code,  'message' => $message);
            }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message);
        }
    
        return response()->json($json, 200);
    }
    //END 

    

    //UPDATE WIDTH HIGEHT OF PROCESS ROLE 
    public function updateProcessRoleDetails(Request $request)
    {
        try 
        {   
            $json               =   array();
            $planing_code       =   $request->planing_code;
            $user_id            =   $request->user_id;
            $role_id            =   $request->role_id;
            $length             =   $request->length;
            $width              =   $request->width;
            $weight             =   $request->weight;
			$remarks            =   $request->remarks;
            $date               =   date('Y-m-d H:i:s');
            $planing_step       =   '';
			
			/*if($role_id == '2' || $role_id == '9')
            {
                $process = DB::table('planings')->where('planning_step', '=', 'Planning')->orwhere('planning_step', '=', 'InProcess')->get();
            }
            elseif($role_id == '3')
            {
                $process = DB::table('planings')->where('planning_step', '=', 'First')->orwhere('planning_step', '=', 'InProcess')->get();
            }
            elseif($role_id == '4')
            {
                $process = DB::table('planings')->where('planning_step', '=', 'Second')->orwhere('planning_step', '=', 'InProcess')->get();
            }
            elseif($role_id == '5')
            {
                $process = DB::table('planings')->where('planning_step', '=', 'Third')->orwhere('planning_step', '=', 'InProcess')->get();
            }
			elseif($role_id == '6')
            {
                $process = DB::table('planings')->where('planning_step', '=', 'Fourth')->orwhere('planning_step', '=', 'InProcess')->get();
            }*/
            
			if($role_id == 2 || $role_id == 9)
            {
                $planing_step = 'Planning';
            }
            elseif($role_id == 3)
            {
                $planing_step = 'First';
            }
            elseif($role_id == 4)
            {
                $planing_step = 'Second';
            }
            elseif($role_id == 5)
            {
                $planing_step = 'Third';
            }
            elseif($role_id == 6)
            {
                $planing_step = 'Fourth';
            }
			elseif($role_id == 10)
            {
                $planing_step = 'PlanningFirst';
            }
            else
            {
                $process = array();
                $planing_step       =   '';
                $status_code = '0';
                $message = 'Sorry! Access denied for update process data';
                $json = array('status_code' => $status_code,  'message' => $message);
            }
			
			$current_step = $next_step = "";
			
			if($planing_step != '')
            {   
                $process = DB::table('planings')->where('planing_code', '=', $planing_code)->first();
                if($process)
                {
                    $process_id = $process->id;
					$current_step = $process->planning_step;
					$planing_lotno = $process->lot_no;
					
					// Get Next Step
					$process_steps = DB::table('process_steps')->where('planing_lotno', '=', $planing_lotno)->where('steps', '=', $current_step)->first();
					
					$next_id = '';
					if($process_steps)
					{
						$next_id = $process_steps->id;
					}
					
					$process_steps_next = DB::table('process_steps')->where('planing_lotno', '=', $planing_lotno)->where('id', '>', $next_id)->first();
					if($process_steps_next)
					{
						$next_step = $process_steps_next->steps;
					}
					
					DB::table('planings')->where('id', '=', $process_id)->update(['planning_step' => $next_step, 'length' => $length, 'width' => $width, 'weight' => $weight, 'planning_isprogress' => '0', 'scanner_user_id' => NULL, 'updated_at' => $date]);

                    DB::table('planning_history')->insert(['planning_id' => $process_id, 'planing_step' => $next_step, 'length' => $length, 'width' => $width, 'weight' => $weight, 'remarks' => $remarks, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date]); 
                    $status_code = '1';
                    $message = 'Role details updated succesfully!';
                    $json = array('status_code' => $status_code, 'message' => $message);
				}
				else
                {
					$status_code = '0';
					$message = 'Sorry! something went wrong';
					$json = array('status_code' => $status_code, 'message' => $message);     
				}
			}
			
			//echo $current_step.",".$next_step; dd($request);
            
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message);
        }
    
        return response()->json($json, 200);
    }

    //END
	
	//UPDATE WIDTH HIGEHT OF PROCESS ROLE 
    public function updateCompleteCode(Request $request)
    {
        try 
        {   
            $json               =   array();
            $planing_code       =   $request->planing_code;
			$updated_planing_code       =   $request->updated_planing_code;
            $user_id            =   $request->user_id;
            $role_id            =   $request->role_id;
            $date               =   date('Y-m-d H:i:s');
            $planing_step       =   '';
			
			if($role_id == 2)
            {
                $planing_step = 'First';
            }
            elseif($role_id == 3)
            {
                $planing_step = 'Second';
            }
            elseif($role_id == 4)
            {
                $planing_step = 'Third';
            }
            elseif($role_id == 5)
            {
                $planing_step = 'Fourth';
            }
            elseif($role_id == 6)
            {
                $planing_step = 'Complete';
            }
			elseif($role_id == '9')
            {
                $planing_step = 'Planning';
            }
			elseif($role_id == '10')
            {
                $planing_step = 'PlanningFirst';
            }
            else
            {
                $process = array();
                $planing_step       =   '';
                $status_code = '0';
                $message = 'Sorry! Access denied for update process data';
                $json = array('status_code' => $status_code,  'message' => $message);
            }
			
			$updatePlaning = json_decode($updated_planing_code);
			//echo '<pre>'; print_r($updatePlaning); exit;
			
			if($planing_step != '')
            {   
                $process = DB::table('planings')->where('planing_code', '=', $planing_code)->first();
                if($process)
                {
                    $process_id = $process->id;
					$current_step = $process->planning_step;
					
					$planing_step = 'Complete';
					
					// Planning Data
					DB::table('planings')->where('planing_code', '=', $planing_code)->update(['updated_at' => date('Y-m-d H:i:s'), 'planning_step' => $planing_step, 'user_id' => $user_id]);
			
            		DB::table('planning_history')->insert(['planning_id' => $process_id, 'length' => $request->length, 'width' => $request->width, 'weight' => $request->weight, 'remarks' => $request->remarks, 'planing_step' => $planing_step, 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			
					if(isset($updatePlaning))
					{
						foreach($updatePlaning as $k => $planning_code_data)
						{
							$planing_code_code = $planning_code_data->code;
							
							$planing_qrcode = time().'-'.rand().'.png';
		
							QR_Code::png($planing_code, public_path().'/uploads/planing/'.$planing_qrcode, QR_ECLEVEL_L, 15, 2); 
				
							$planing_qrcode_images = 'uploads/planing/'.$planing_qrcode;
					
							DB::table('planning_codes')->insert(['planning_id' => $process_id, 'user_id' => $user_id, 'planing_code' => $planing_code, 'planning_code_qrcode' => $planing_qrcode_images, 'planning_code_code' => $planing_code_code, 'length' => $planning_code_data->length, 'width' => $planning_code_data->width, 'weight' => $planning_code_data->weight, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
						
						$status_code = '1';
						$message = 'Role details updated succesfully with planing '.$planing_code." ".$planing_step;
						$json = array('status_code' => $status_code, 'message' => $message);
					}
					else
					{
						$status_code = '1';
						$message = 'Role details updated succesfully!'.print_r($updatePlaning, 1);
						$json = array('status_code' => $status_code, 'message' => $message);
					}
				}
				else
				{
					$status_code = '0';
					$message = 'Sorry! Planning code not exists.';
					$json = array('status_code' => $status_code,  'message' => $message);
				}
			}
			
			
			//echo $current_step.",".$next_step; dd($request);
            
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message);
        }
    
        return response()->json($json, 200);
    }

    //END

    //START INSERT QR CODE FOR EXPORT INTO EXCEL
    public function qrCodeExport(Request $request)
    {
        try 
        {   
            $json               =   array();
            $planing_code       =   $request->planing_code;
            $user_id            =   $request->user_id;
			$scan_name            =   $request->scan_name;
            $date               =   date('Y-m-d H:i:s');
			//$timestamp = time();
			
			//$planningCodeData = json_decode($planing_code);
			$planningCodeData = explode(",", $planing_code);
			//echo '<pre>';print_r($planningCodeData); exit;
			
			if($planningCodeData)
			{
				$export_id = DB::table('qr_exports')->insertGetId(['status' => '1', 'user_id' => $user_id, 'scan_timestamp' => $scan_name, 'created_at' => $date, 'updated_at' => $date]);
				
				foreach($planningCodeData as $planningCodeRow)
				{
                    $planing_qrcode = time().'-'.rand().'.png';

                    QR_Code::png($planningCodeRow, public_path().'/uploads/planing/'.$planing_qrcode, QR_ECLEVEL_L, 15, 2); 


                    $planing_qrcode_images = 'uploads/planing/'.$planing_qrcode;

					DB::table('qr_export_details')->insert(['qr_code' => $planningCodeRow, 'qr_image' => $planing_qrcode_images, 'export_id' => $export_id, 'created_at' => $date, 'updated_at' => $date]);
				}
				$status_code = '1';
				$message    =  "QR sent for export"; 
				$json = array('status_code' => $status_code, 'message' => $message); 
			}
			else
            {
               $status_code = '0';
               $message    =  "Sorry! invalid QR code"; 
               $json = array('status_code' => $status_code, 'message' => $message);  
            }
        }
        catch(\Exception $e) {
            $status_code = '0';
            $message = $e->getMessage();//$e->getTraceAsString(); getMessage //
    
            $json = array('status_code' => $status_code, 'message' => $message);
        }
    
        return response()->json($json, 200);
    }
    //END
}
