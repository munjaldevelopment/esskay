<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\LenderBanking;
use App\Models\Planings;

use App\Exports\LenderBankingExport;
use App\Exports\LenderBankingDetailExport;

use App\Imports\LenderBankingImport;
use App\Imports\LenderBankingDetailImport;

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
	public function exportXLSPlanning()
    {
        $this->data['title'] = 'Export Planning XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning', $this->data);
    }
	
	public function exportPDFPlanning()
    {
        $this->data['title'] = 'Export Planning PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning', $this->data);
    }
	
	// Export Planning History Data
	public function exportXLSPlanningHistory()
    {
        $this->data['title'] = 'Export Planning History XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();
		//dd($lotNoData);

        return view('backpack::export_xls_planning_history', $this->data);
    }
	
	public function exportXLSPlanningHistoryData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningHistoryDataExport::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('PlaningHistory_'.date('Y-m-d').'.xls');
	}
	
	
	// Export Planning Code Data
	public function exportXLSPlanningCode()
    {
        $this->data['title'] = 'Export Planning Code XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning_code', $this->data);
    }
	
	public function exportPDFPlanningCode()
    {
        $this->data['title'] = 'Export Planning Code PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_code', $this->data);
    }
	
	// Planning
	public function exportXLSPlanningCodeData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningCodeDataExport::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('PlaningCode_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningCodeData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		$plannings = \DB::table('planning_codes')->whereDate('updated_at', '>=', $request['date_from'])->whereDate('updated_at', '<=', $request['date_to'])->get();
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->planning_code_qrcode, 'planning_code' => $planning->planing_code, 'planning_code_code' => $planning->planning_code_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_code_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	// Planning One
	public function exportXLSProcessOne()
    {
        $this->data['title'] = 'Export Process XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning_one', $this->data);
    }
	
	public function exportPDFProcessOne()
    {
        $this->data['title'] = 'Export Process PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_one', $this->data);
    }

    public function exportPDF()
    {
        $this->data['title'] = 'Export Process PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_one', $this->data);
    }
	
	public function exportXLSProcessTwo()
    {
        $this->data['title'] = 'Export Process XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning_two', $this->data);
    }
	
	public function exportPDFProcessTwo()
    {
        $this->data['title'] = 'Export Process PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_two', $this->data);
    }
	
	public function exportXLSProcessThree()
    {
        $this->data['title'] = 'Export Process XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning_three', $this->data);
    }
	
	public function exportPDFProcessThree()
    {
        $this->data['title'] = 'Export Process PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_three', $this->data);
    }
	
	public function exportXLSProcessFour()
    {
        $this->data['title'] = 'Export Process XLS';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_xls_planning_four', $this->data);
    }
	
	public function exportPDFProcessFour()
    {
        $this->data['title'] = 'Export Process PDF';//trans('backpack::base.dashboard'); // set the page title
		$this->data['start_date'] = date('Y-m-01');
$this->data['today_date'] = date('Y-m-d');
		$this->data['lotNoData'] = $lotNoData = Planings::getLotNo();

        return view('backpack::export_pdf_planning_four', $this->data);
    }
	
	// Planning
	public function exportXLSPlanningData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningFirstExport::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		
		$lot_no = $request['lot_no'];
		
		if($lot_no != "")
		{
			$plannings = \DB::table('planings')->where('lot_no', '=', $lot_no)->whereDate('updated_at', '>=', $request['date_from'])->whereDate('updated_at', '<=', $request['date_to'])->get();
		}
		else
		{
			$plannings = \DB::table('planings')->whereDate('updated_at', '>=', $request['date_from'])->whereDate('updated_at', '<=', $request['date_to'])->get();
		}
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	// Planning
	public function exportXLSPlanningOneData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningStep1Export::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningOneData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		
		$start_date = $request['date_from'];
		$end_date = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		if($lot_no != "")
		{
			$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'First')->where('planings.lot_no', '=', $lot_no)->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		else
		{
        	$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'First')->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	public function exportXLSPlanningTwoData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningStep2Export::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningTwoData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		
		$start_date = $request['date_from'];
		$end_date = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		if($lot_no != "")
		{
			$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Second')->where('planings.lot_no', '=', $lot_no)->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		else
		{
        	$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Second')->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	public function exportXLSPlanningThreeData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningStep3Export::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningThreeData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		
		$start_date = $request['date_from'];
		$end_date = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		if($lot_no != "")
		{
			$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Third')->where('planings.lot_no', '=', $lot_no)->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		else
		{
        	$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Third')->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	public function exportXLSPlanningFourData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = $request['date_from'];
		$date_to = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		$exporter = app()->makeWith(PlanningStep4Export::class, compact('date_from', 'date_to', 'lot_no'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function exportPDFPlanningFourData(Request $request)
	{
		//dd($request->all());
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		
		$start_date = $request['date_from'];
		$end_date = $request['date_to'];
		$lot_no = $request['lot_no'];
		
		if($lot_no != "")
		{
			$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Fourth')->where('planings.lot_no', '=', $lot_no)->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		else
		{
        	$plannings = \DB::table('planning_history')->leftJoin('planings', 'planning_history.planning_id', '=', 'planings.id')->where('planning_history.planing_step', '=', 'Fourth')->whereDate('planings.updated_at', '>=', $start_date)->whereDate('planings.updated_at', '<=', $end_date)->select('planings.*')->orderBy('planings.id', 'ASC')->get();
		}
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code, 'created_at' => $planning->created_at);
			}
			
			$base_url = env('APP_URL');
		
			view()->share('plannings',$planingData);
			
			//return view('backpack::download_planning', compact('base_url', 'plannings'));
			//exit;
			//view()->share('plannings',$plannings);
			view()->share('base_url',$base_url);
			
			$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
			return $pdf->download('planning-'.date('y-m-d').'.pdf');
		}
		else
		{
			$error = 'No planning exists for this timeframe. Please try again or choose another date';
			return back()->with('error', $error);
		}
	}
	
	
	// Planning
	public function exportPlanning(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = date('Y-m-d');
		$exporter = app()->makeWith(PlanningCurrentExport::class, compact('date_from'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
		
		
	}
	
	public function exportPlanningHistory(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$date_from = date('Y-m-d');
		$exporter = app()->makeWith(PlanningHistoryExport::class, compact('date_from'));   
		return $exporter->download('Planing_'.date('Y-m-d').'.xls');
	}
	
	public function importPlanning()
    {
        $this->data['title'] = 'Import Planning';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_planning', $this->data);
    }
	
	public function insertPlanning(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('planning_file')){
			$fileName = $request->file('planning_file')->getClientOriginalName();
			$path = $request->file('planning_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/planning_file/'.$fileNameTemp);
			
			$sheet_data = Excel::load($path, function($reader) { $reader->ignoreEmpty(); })->formatDates( true, 'Y-m-d' )->get();
			
			$error = $success = '';
			
			define('IMAGE_WIDTH',100);
			define('IMAGE_HEIGHT',100);
			
			$counterInsert = $counterNotInsert = $counterUpdate = 0;
			
			$sheet_title = $sheet_data->getTitle();
			if($sheet_title == "Planning")
			{
				// Enter Planning 
				$expected_heading = array( "id", "planning_code");//dd($sheet_data->toArray());
				
				$sheetHeadingData = $sheet_data->getHeading();
				
				if(count($sheetHeadingData) == 2)
				{
					$isHeading = true;
				
					foreach($expected_heading as $k => $heading)
					{
						if($heading != $sheetHeadingData[$k])
						{
							$isHeading = false;
						}
					}
					
					if($isHeading)
					{
						// Truncate Planning
						\DB::table('plannings')->truncate();
						
						// Modified by Munjal
						if(!empty($sheet_data) && $sheet_data->count()){
							$insert = array();
							foreach ($sheet_data->toArray() as $key => $value) {
								$planning_code = isset($value['planning_code']) ? $value['planning_code'] : "";
								
								if($planning_code != "")
								{
									// Check if CODE already exists
									$isExists = Planning::where('planning_code', '=', $planning_code)->count();
									
									if($isExists == 0)
									{
										$planning_qrcode = time().'-'.rand().'.png';//$planning_code;
										$planning_file = QR_Code::png($planning_code, public_path().'/uploads/import_file/planning_qrcode/'.$planning_qrcode, QR_ECLEVEL_L, 15, 2); //10
										$planning = new Planning;
										$planning->planning_code = $planning_code;
										$planning->planning_qrcode = "uploads/import_file/planning_qrcode/".$planning_qrcode;
										$planning->save();
									}
								}
							}
							
							$success = '<ul><li>'.$counterInsert.' rows Inserted successfully.</li>'; /// '.$counterUpdate.' rows Updated
						}
					}
					else
					{
						$error = 'Something wrong with file heading sequence. Please re-check the file. Please contact administrator for more detail.';
					}
				}
				else
				{
					$error = 'Sorry! You are Importing Wrong file. Please use Export sheet only.';
				}
			}
			else
			{
				$error = 'Sorry! You are Importing Wrong file. Please use Export sheet only.';
			}
			
			if($error != "")
			{
				return back()->with('error', $error);
			}
			else if($success != "")
			{
				return back()->with('success', $success);
			}
		}
		
		return back()->with('error','Please choose export sheet. You haven\'t chosen any file.');
	}
	
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
	
	public function exportPlanningHistoryPDF(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		$planingData = array();
		$plannings = \DB::table('planings')->whereDate('updated_at', '<', date('Y-m-d'))->get();
		
		if($plannings)
		{
			foreach($plannings as $k => $planning)
			{
				$planingData[$k] = array('qr_image' => $planning->qr_image, 'planning_code' => $planning->planing_code);
			}
		}
		
		$base_url = env('APP_URL');
		
		view()->share('plannings',$planingData);
		
		//return view('backpack::download_planning', compact('base_url', 'plannings'));
		//exit;
		//view()->share('plannings',$plannings);
		view()->share('base_url',$base_url);
		
		$pdf = PDF::loadView('backpack::download_planning_history')->setPaper('A4', 'portrait');
		return $pdf->download('planning-'.date('y-m-d').'.pdf');
	}
	//END SHADE
}
