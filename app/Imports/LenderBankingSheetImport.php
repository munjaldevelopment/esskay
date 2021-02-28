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

use Auth;

class LenderBankingSheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*lender" => "A K Capital Services Limited"
        "banking_arrangment" => "TL - Secured"
        "sanction" => 0.0
        "outstanding" => 0.0
        "status*/
		define('IMAGE_WIDTH',100);
		define('IMAGE_HEIGHT',100);
			
		\DB::table('lender_banking')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$lender_banking_id = $row['id'];
			$lender = isset($row['lender']) ? trim($row['lender']) : "";
			$lender_banking_code = isset($row['lender_banking_code']) ? trim($row['lender_banking_code']) : "";
			$banking_arrangment = isset($row['banking_arrangment']) ? trim($row['banking_arrangment']) : "";
								
			if($lender != "" && $banking_arrangment != "")
			{
				// Check if CODE already exists
				$isExists = Lender::where('name', '=', $lender)->count();
				$isExists1 = BankingArrangment::where('name', '=', $banking_arrangment)->count();
				
				if($isExists > 0 && $isExists1 > 0)
				{
					$lenderData = Lender::where('name', '=', $lender)->first();
					$bankingData = BankingArrangment::where('name', '=', $banking_arrangment)->first();
					
					$lenderBanking = new LenderBanking;
					$lenderBanking->id = $lender_banking_id;
					$lenderBanking->lender_id = $lenderData->id;
					$lenderBanking->banking_arrangment_id = $bankingData->id;
					$lenderBanking->lender_banking_code = $row['lender_banking_code'];
					$lenderBanking->sanction_amount = $row['sanction'];
					$lenderBanking->outstanding_amount = $row['outstanding'];
					$lenderBanking->lender_banking_status = ($row['status'] == "Yes" ? "1" : "0");
					$lenderBanking->save();
				}
			}
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'lender' => 'required',
            'banking_arrangment' => 'required',
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
			'banking_arrangment' => 'Message 2.',
			'sanction' => 'Message 2.',
			'outstanding' => 'Message 2.',
			'status' => 'Message 2.',
		];
	}
	
}
