<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\StrongLiabilityProfileTable;

use Auth;

class StrongLiabilityTableImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*dec_18" => 1.99
        "mar_19" => 64.46
        "jun_19" => 11.18
        "sep_19" => 8.58
        "dec_19" => 90.42
        "mar_20" => 73.72
        "jun_20" => 5.97
        "sep_20" => 38.95
        "nov_20
        "status"*/
		
		\DB::table('strong_liability_profile_tables')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$quarter_on_quarter_liquidity = $row['lender'];

			$mar_16_amount = $row['mar_16_amount'];
			$mar_16_lenders = $row['mar_16_lenders'];
			$mar_17_amount = $row['mar_17_amount'];
			$mar_17_lenders = $row['mar_17_lenders'];
			$mar_18_amount = $row['mar_18_amount'];
			$mar_18_lenders = $row['mar_18_lenders'];
			$mar_19_amount = $row['mar_19_amount'];
			$mar_19_lenders = $row['mar_19_lenders'];
			$mar_20_amount = $row['mar_20_amount'];
			$mar_20_lenders = $row['mar_20_lenders'];
			$nov_20_amount = $row['nov_20_amount'];
			$nov_20_lenders = $row['nov_20_lenders'];


			$lenderBanking = new StrongLiabilityProfileTable;
			$lenderBanking->lender = $quarter_on_quarter_liquidity;
			$lenderBanking->amount1 = $mar_16_amount;
			$lenderBanking->amount1_lender = $mar_16_lenders;
			$lenderBanking->amount2 = $mar_17_amount;
			$lenderBanking->amount2_lender = $mar_17_lenders;
			$lenderBanking->amount3 = $mar_18_amount;
			$lenderBanking->amount3_lender = $mar_18_lenders;
			$lenderBanking->amount4 = $mar_19_amount;
			$lenderBanking->amount4_lender = $mar_19_lenders;
			$lenderBanking->amount5 = $mar_20_amount;
			$lenderBanking->amount5_lender = $mar_20_lenders;
			$lenderBanking->amount6 = $nov_20_amount;
			$lenderBanking->amount6_lender = $nov_20_lenders;

			$lenderBanking->strong_liability_table_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'lender' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'lender' => 'Message 2.',
            'status' => 'Message 5.',
		];
	}
	
}
