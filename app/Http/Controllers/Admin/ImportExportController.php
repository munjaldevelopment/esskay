<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\LenderBanking;
use App\Models\Planings;

use App\Exports\LenderBankingExport;
use App\Exports\LenderBankingDetailExport;
use App\Exports\OperationalHighlightExport;
use App\Exports\GeographicalConcentrationExport;
use App\Exports\ProductConcentrationExport;
use App\Exports\AssetQualityExport;
use App\Exports\CollectionEfficiencyExport;
use App\Exports\NetWorthExport;
use App\Exports\LiquidityExport;
use App\Exports\StrongLiabilityExport;
use App\Exports\CurrentDealExport;

use App\Imports\LenderBankingImport;
use App\Imports\LenderBankingDetailImport;
use App\Imports\OperationalHighlightImport;
use App\Imports\GeographicalConcentrationImport;
use App\Imports\ProductConcentrationImport;
use App\Imports\AssetQualityImport;
use App\Imports\CollectionEfficiencyImport;
use App\Imports\NetWorthImport;
use App\Imports\LiquidityImport;
use App\Imports\StrongLiabilityImport;
use App\Imports\CurrentDealImport;

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

	// START GeographicalConcentration
	public function exportGeographicalConcentration(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new GeographicalConcentrationExport())->download('GeographicalConcentration_'.date('Y-m-d').'.xls');
	}
	
	public function importGeographicalConcentration()
    {
        $this->data['title'] = 'Import Geographical Concentration';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_geographical_concentration', $this->data);
    }
	
	public function insertGeographicalConcentration(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('geographical_concentration_file')){
			$fileName = $request->file('geographical_concentration_file')->getClientOriginalName();
			$path = $request->file('geographical_concentration_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/geographical_concentration_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new GeographicalConcentrationImport, public_path().'/uploads/import_file/geographical_concentration_file/'.$fileNameTemp);
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
	// END GeographicalConcentration

	// START ProductConcentration
	public function exportProductConcentration(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new ProductConcentrationExport())->download('ProductConcentration_'.date('Y-m-d').'.xls');
	}
	
	public function importProductConcentration()
    {
        $this->data['title'] = 'Import Product Concentration';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_product_concentration', $this->data);
    }
	
	public function insertProductConcentration(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('product_concentration_file')){
			$fileName = $request->file('product_concentration_file')->getClientOriginalName();
			$path = $request->file('product_concentration_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/product_concentration_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new ProductConcentrationImport, public_path().'/uploads/import_file/product_concentration_file/'.$fileNameTemp);
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
	// END ProductConcentration

	// START AssetQuality
	public function exportAssetQuality(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new AssetQualityExport())->download('AssetQuality_'.date('Y-m-d').'.xls');
	}
	
	public function importAssetQuality()
    {
        $this->data['title'] = 'Import Asset Quality';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_asset_quality', $this->data);
    }
	
	public function insertAssetQuality(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('asset_quality_file')){
			$fileName = $request->file('asset_quality_file')->getClientOriginalName();
			$path = $request->file('asset_quality_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/asset_quality_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new AssetQualityImport, public_path().'/uploads/import_file/asset_quality_file/'.$fileNameTemp);
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
	// END AssetQuality
	
	// START CollectionEfficiency
	public function exportCollectionEfficiency(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new CollectionEfficiencyExport())->download('CollectionEfficiency_'.date('Y-m-d').'.xls');
	}
	
	public function importCollectionEfficiency()
    {
        $this->data['title'] = 'Import Collection Efficiency';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_collection_efficiency', $this->data);
    }
	
	public function insertCollectionEfficiency(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('collection_efficiency_file')){
			$fileName = $request->file('collection_efficiency_file')->getClientOriginalName();
			$path = $request->file('collection_efficiency_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/collection_efficiency_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new CollectionEfficiencyImport, public_path().'/uploads/import_file/collection_efficiency_file/'.$fileNameTemp);
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
	// END CollectionEfficiency

	// START NetWorth
	public function exportNetWorth(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new NetWorthExport())->download('NetWorth_'.date('Y-m-d').'.xls');
	}
	
	public function importNetWorth()
    {
        $this->data['title'] = 'Import Net Worth';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_net_worth', $this->data);
    }
	
	public function insertNetWorth(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('net_worth_file')){
			$fileName = $request->file('net_worth_file')->getClientOriginalName();
			$path = $request->file('net_worth_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/net_worth_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new NetWorthImport, public_path().'/uploads/import_file/net_worth_file/'.$fileNameTemp);
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
	// END NetWorth
	
	// START Liquidity
	public function exportLiquidity(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new LiquidityExport())->download('Liquidity_'.date('Y-m-d').'.xls');
	}
	
	public function importLiquidity()
    {
        $this->data['title'] = 'Import Liquidity';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_liquidity', $this->data);
    }
	
	public function insertLiquidity(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('liquidity_file')){
			$fileName = $request->file('liquidity_file')->getClientOriginalName();
			$path = $request->file('liquidity_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/liquidity_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new LiquidityImport, public_path().'/uploads/import_file/liquidity_file/'.$fileNameTemp);
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
	// END Liquidity

	// START StrongLiability
	public function exportStrongLiability(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new StrongLiabilityExport())->download('StrongLiability_'.date('Y-m-d').'.xls');
	}
	
	public function importStrongLiability()
    {
        $this->data['title'] = 'Import StrongLiability';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_strong_liability', $this->data);
    }
	
	public function insertStrongLiability(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('strong_liability_file')){
			$fileName = $request->file('strong_liability_file')->getClientOriginalName();
			$path = $request->file('strong_liability_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/strong_liability_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new StrongLiabilityImport, public_path().'/uploads/import_file/strong_liability_file/'.$fileNameTemp);
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
	// END StrongLiability
	
	// START CurrentDeal
	public function exportCurrentDeal(Request $request)
	{
		$this->data['title'] = trans('backpack::base.dashboard'); // set the page title
		
		return (new CurrentDealExport())->download('CurrentDeal_'.date('Y-m-d').'.xls');
	}
	
	public function importCurrentDeal()
    {
        $this->data['title'] = 'Import Current Deal';//trans('backpack::base.dashboard'); // set the page title

        return view('backpack::import_current_deal', $this->data);
    }
	
	public function insertCurrentDeal(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		
		if($request->hasFile('current_deal_file')){
			$fileName = $request->file('current_deal_file')->getClientOriginalName();
			$path = $request->file('current_deal_file')->getRealPath();
			
			$fileNameTemp = time()."_".$user_id."_".$fileName;
			copy($path, public_path().'/uploads/import_file/current_deal_file/'.$fileNameTemp);
			
			$error = $success = '';
			
			try {
			
				Excel::import(new CurrentDealImport, public_path().'/uploads/import_file/current_deal_file/'.$fileNameTemp);
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
	// END CurrentDeal

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
