<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\StrongLiabilityProfileDriving;

use Auth;

class StrongLiabilityDrivingImport implements ToCollection, WithValidation, WithHeadingRow
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
		
		\DB::table('strong_liability_profile_driving')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$financial_year = $row['financial_year'];
			$amount1 = $row['tier1'];
			$amount2 = $row['tier2'];

			$lenderBanking = new StrongLiabilityProfileDriving;
			$lenderBanking->financial_year = $financial_year;
			$lenderBanking->amount1 = $amount1;
			$lenderBanking->amount2 = $amount2;

			$lenderBanking->strong_liability_driving_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'financial_year' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'financial_year' => 'Message 2.',
            'status' => 'Message 5.',
		];
	}
	
}
