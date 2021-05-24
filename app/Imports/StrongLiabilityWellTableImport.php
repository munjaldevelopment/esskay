<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\StrongLiabilityProfileWellTable;

use Auth;

class StrongLiabilityWellTableImport implements ToCollection, WithValidation, WithHeadingRow
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
		
		\DB::table('strong_liability_profile_well_table')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$particulars = $row['particulars'];
			$amount1 = $row['as_per_igaap_fy16'];
			$amount2 = $row['as_per_igaap_fy17'];
			$amount3 = $row['as_per_igaap_fy18'];
			$amount4 = $row['as_per_ind_as_fy16'];
			$amount5 = $row['as_per_ind_as_fy17'];
			$amount6 = $row['as_per_ind_as_fy18'];
			$amount7 = $row['as_per_igaap_fy21'];

			$lenderBanking = new StrongLiabilityProfileWellTable;
			$lenderBanking->particulars = $particulars;
			$lenderBanking->amount1 = $amount1;
			$lenderBanking->amount2 = $amount2;
			$lenderBanking->amount3 = $amount3;
			$lenderBanking->amount4 = $amount4;
			$lenderBanking->amount5 = $amount5;
			$lenderBanking->amount6 = $amount6;
			$lenderBanking->amount7 = $amount7;

			$lenderBanking->strong_liability_well_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'particulars' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'particulars' => 'Message 2.',
            'status' => 'Message 5.',
		];
	}
	
}
