<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\StrongLiabilityProfile;

use Auth;

class StrongLiabilityImport implements ToCollection, WithValidation, WithHeadingRow
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
		
		\DB::table('strong_liability_profiles')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$quarter_on_quarter_liquidity = $row['quarter'];
			$dec_18 = $row['bankfi'];
			$mar_19 = $row['cme_from_mf'];
			$jun_19 = $row['others'];

			$lenderBanking = new StrongLiabilityProfile;
			$lenderBanking->quarter = $quarter_on_quarter_liquidity;
			$lenderBanking->amount1 = $dec_18;
			$lenderBanking->amount2 = $mar_19;
			$lenderBanking->amount3 = $jun_19;

			$lenderBanking->strong_liability_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'quarter' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'quarters' => 'Message 2.',
            'status' => 'Message 5.',
		];
	}
	
}
