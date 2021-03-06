<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\LenderBanking;
use App\Models\Planings;

use App\Exports\LenderBankingExport;
use App\Exports\LenderBankingDetailExport;
use App\Exports\OperationalHighlightExport;

use App\Imports\LenderBankingImport;
use App\Imports\LenderBankingDetailImport;
use App\Imports\OperationalHighlightImport;

use Auth;
use Excel;
use PDF;
use Validator;
use QR_Code\QR_Code;

class ImportExportController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }
	
	// LenderBanking
	public function exportLenderBanking(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new LenderBankingExport())->download('LenderBanking_'.date('Y-m-d').'.xls');
	}
	
	public function importLenderBanking()
    {
        $this->data['title'] = 'Import Lender Banking';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_lender_banking', $this->data);
    }
	
	public function insertLenderBanking(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('lender_banking_file')){
			$fileName = $request->file('lender_banking_file')->getClientOriginalName();
			$path = $request->file('lender_banking_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/lender_banking_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new LenderBankingImport, public_path().'/uploads/import_file/lender_banking_file/'.$fileNameTemp);
				$success = 'Your sheet has been imported successfully.';
				
				return back()->with('success', $success);
			} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
				$failures = $e->failures();
				//dd($failures);
				
				$error = "";
				 
				foreach ($failures as $failure) {
					$failure->row(); // row that went wrong
					$failure->attribute(); // either heading key (if using heading row concern) or column index
					foreach($failure->errors() as $err)
					{
						$error .= $err;
					}
					
					$error .= " on line number ".$failure->row().' <br />';
					// Actual error messages from Laravel validator
					$failure->values(); // The values of the row that has failed.
				}
				
				//echo $error; exit;
				
				return back()->with('error', $error);
			}
		}
		
		return back()->with('error','Please choose export sheet. You haven\'t chosen any file.');
	}
	
	public function exportLenderBankingPDF(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$factories = LenderBanking::get();
		$base_url = env('APP_URL');
		
		view()->share('factories',$factories);
		view()->share('base_url',$base_url);
		
		$pdf = PDF::loadView('backpack::download_factory')->setPaper('A4', 'portrait');
		return $pdf->download('factory-'.date('y-m-d').'.pdf');
	}
	//END Lender Banking

	// LenderBankingDetail
	public function exportLenderBankingDetail(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new LenderBankingDetailExport())->download('LenderBankingDetail_'.date('Y-m-d').'.xls');
	}
	
	public function importLenderBankingDetail()
    {
        $this->data['title'] = 'Import Lender Banking Detail';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_lender_banking_detail', $this->data);
    }
	
	public function insertLenderBankingDetail(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('lender_banking_detail_file')){
			$fileName = $request->file('lender_banking_detail_file')->getClientOriginalName();
			$path = $request->file('lender_banking_detail_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/lender_banking_detail_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new LenderBankingDetailImport, public_path().'/uploads/import_file/lender_banking_detail_file/'.$fileNameTemp);
				$success = 'Your sheet has been imported successfully.';
				
				return back()->with('success', $success);
			} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
				$failures = $e->failures();
				
				$error = "";
				 
				foreach ($failures as $failure) {
					$failure->row(); // row that went wrong
					$failure->attribute(); // either heading key (if using heading row concern) or column index
					foreach($failure->errors() as $err)
					{
						$error .= $err;
					}
					
					$error .= " on line number ".$failure->row().' <br />';
					// Actual error messages from Laravel validator
					$failure->values(); // The values of the row that has failed.
				}
				
				//echo $error; exit;
				
				return back()->with('error', $error);
			}
		}
		
		return back()->with('error','Please choose export sheet. You haven\'t chosen any file.');
	}
	//END LenderBankingDetail
	
	// Export Planning Data

	// START OPERATIOANAL HIGHLIGHT
	// OperationalHighlight
	public function exportOperationalHighlight(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new OperationalHighlightExport())->download('OperationalHighlight_'.date('Y-m-d').'.xls');
	}
	
	public function importOperationalHighlight()
    {
        $this->data['title'] = 'Import Operational Highlight';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_operational_highlight', $this->data);
    }
	
	public function insertOperationalHighlight(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('operational_highlight_file')){
			$fileName = $request->file('operational_highlight_file')->getClientOriginalName();
			$path = $request->file('operational_highlight_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/operational_highlight_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new OperationalHighlightImport, public_path().'/uploads/import_file/operational_highlight_file/'.$fileNameTemp);
				$success = 'Your sheet has been imported successfully.';
				
				return back()->with('success', $success);
			} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
				$failures = $e->failures();
				//dd($failures);
				
				$error = "";
				 
				foreach ($failures as $failure) {
					$failure->row(); // row that went wrong
					$failure->attribute(); // either heading key (if using heading row concern) or column index
					foreach($failure->errors() as $err)
					{
						$error .= $err;
					}
					
					$error .= " on line number ".$failure->row().' <br />';
					// Actual error messages from Laravel validator
					$failure->values(); // The values of the row that has failed.
				}
				
				//echo $error; exit;
				
				return back()->with('error', $error);
			}
		}
		
		return back()->with('error','Please choose export sheet. You haven\'t chosen any file.');
	}
	// END OPERATIONAL HIGHLIGHT
	
	
	public function exportPlanningPDF(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
        $plannings = \DB::table('planings')->whereDate('updated_at', '=', date('Y-m-d'))->get();
		
		//dd($plannings);
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code);
			}
		}
		
		$base_url = env('APP_URL');
		
		view()->share('plannings',$planingData);
		view()->share('base_url',$base_url);
		
		$pdf = PDF::loadView('backpack::download_planning')->setPaper('A4', 'portrait');
		return $pdf->download('planning-'.date('y-m-d').'.pdf');
	}
}
