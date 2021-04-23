<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\Liquidity;

use Auth;

class LiquiditySheetImport implements ToCollection, WithValidation, WithHeadingRow
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
		
		\DB::table('liquidity')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$quarter_on_quarter_liquidity = $row['quarter_on_quarter_liquidity'];
			$dec_18 = $row['dec_18'];
			$mar_19 = $row['mar_19'];
			$jun_19 = $row['jun_19'];
			$sep_19 = $row['sep_19'];
			$dec_19 = $row['dec_19'];
			$mar_20 = $row['mar_20'];
			$jun_20 = $row['jun_20'];
			$sep_20 = $row['sep_20'];
			$nov_20 = $row['dec_20'];
			$mar_21 = $row['mar_21'];

			$lenderBanking = new Liquidity;
			$lenderBanking->quarter = $quarter_on_quarter_liquidity;
			$lenderBanking->amount1 = $dec_18;
			$lenderBanking->amount2 = $mar_19;
			$lenderBanking->amount3 = $jun_19;
			$lenderBanking->amount4 = $sep_19;
			$lenderBanking->amount5 = $dec_19;
			$lenderBanking->amount6 = $mar_20;
			$lenderBanking->amount7 = $jun_20;
			$lenderBanking->amount8 = $sep_20;
			$lenderBanking->amount9 = $nov_20;
			$lenderBanking->amount10 = $mar_21;

			$lenderBanking->liquidity_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'quarter_on_quarter_liquidity' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'quarter_on_quarter_liquidity' => 'Message 2.',
            'status' => 'Message 16.',
		];
	}
	
}
