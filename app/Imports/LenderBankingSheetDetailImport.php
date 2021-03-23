<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\BankingArrangment;
use App\Models\Lender;
use App\Models\LenderBanking;
use App\Models\LenderBankingDetail;

use Auth;

class LenderBankingSheetDetailImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		//"lender" => "A K Capital Services Limited"
        //"lender_banking_code" => "LENDERBANK00529"
        //"lender_banking_detail_code" => "LENDERBANKDETAIL00001"
        //"banking_arrangment" => "TL - Secured"
        //"sanction" => 10
        //"outstanding" => 11
        //"status" => "Yes"
		define('IMAGE_WIDTH',100);
		define('IMAGE_HEIGHT',100);
			
		\DB::table('lender_banking_details')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$lender_banking_id = $row['id'];
			$lender = isset($row['lender']) ? trim($row['lender']) : "";
			$lender_banking_code = isset($row['lender_banking_code']) ? trim($row['lender_banking_code']) : "";
			$lender_banking_detail_code = isset($row['lender_banking_detail_code']) ? trim($row['lender_banking_detail_code']) : "";
			$banking_arrangment = isset($row['banking_arrangment']) ? trim($row['banking_arrangment']) : "";
								
			if($lender != "" && $lender_banking_code != "" && $lender_banking_detail_code != "" && $banking_arrangment != "")
			{
				// Check if CODE already exists
				$isExists = Lender::where('name', '=', $lender)->count();
				$isExists1 = LenderBanking::where('lender_banking_code', '=', $lender_banking_code)->count();
				$isExists2 = BankingArrangment::where('name', '=', $banking_arrangment)->count();
				
				
				if($isExists > 0 && $isExists1 > 0 && $isExists2 > 0)
				{
					if($row['banking_date'] > 0)
					{
						$UNIX_DATE = ($row['banking_date'] - 25569) * 86400;
						$banking_date = gmdate("Y-m-d", $UNIX_DATE);
					}
					else 
					{
						$banking_date = $row['banking_date'];
					}

					$lenderData = Lender::where('name', '=', $lender)->first();
					$lenderBankingData = LenderBanking::where('lender_banking_code', '=', $lender_banking_code)->first();
					$bankingData = BankingArrangment::where('name', '=', $banking_arrangment)->first();
					
					$lenderBanking = new LenderBankingDetail;
					$lenderBanking->lender_id = $lenderData->id;
					$lenderBanking->lender_banking_id = $lenderBankingData->id;
					$lenderBanking->lender_banking_detail_code = $row['lender_banking_detail_code'];
					$lenderBanking->banking_arrangment_id = $bankingData->id;
					$lenderBanking->lender_banking_date = $banking_date;
					$lenderBanking->sanction_amount = $row['sanction'];
					$lenderBanking->outstanding_amount = $row['outstanding'];
					$lenderBanking->lender_banking_status = ($row['status'] == "Yes" ? "1" : "0");
					$lenderBanking->save();
				}
			}
		}

		$result = LenderBankingDetail::selectRaw('lender_id, lender_banking_id, SUM(sanction_amount) as total_sanction_amount, SUM(outstanding_amount)  as total_outstanding_amount')->groupBy('lender_banking_id')->get();

		if($result)
		{
			foreach($result as $row)
			{
				LenderBanking::where(['lender_id' => $row->lender_id, 'id' => $row->lender_banking_id])->update(['sanction_amount' => $row->total_sanction_amount, 'outstanding_amount' => $row->total_outstanding_amount]);
			}
		}

		exit;
    }

	public function rules(): array
	{
		return [
			'id' => 'required',
            'lender' => 'required',
            'lender_banking_code' => 'required',
            'lender_banking_detail_code' => 'required',
            'banking_arrangment' => 'required',
            'banking_date' => 'required',
            'sanction' => 'required',
            'outstanding' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'lender' => 'Message 2.',
            'lender_banking_code' => 'Message 3.',
            'lender_banking_detail_code' => 'Message 4.',
			'banking_arrangment' => 'Message 5.',
			'banking_date' => 'Message 6.',
			'sanction' => 'Message 7.',
			'outstanding' => 'Message 8.',
			'status' => 'Message 9.',
		];
	}
	
}
