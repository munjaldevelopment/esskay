<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\ProductConcentration;

use Auth;

class ProductConcentrationSheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*product_diversification" => "Rajasthan"
        "docp" => "Nov-94"
        "mar_16_amount" => 441
        "mar_16_amount_percent" => 84
        "mar_17_amount" => 663
        "mar_17_amount_percent" => 80
        "mar_18_amount" => 977
        "mar_18_amount_percent" => 76
        "mar_19_amount" => 1466
        "mar_19_amount_percent" => 73
        "mar_20_amount" => 2091
        "mar_20_amount_percent" => 70
        "sep_20_amount" => 1959
        "sep_20_amount_percent" => 69
        "mar_21_amount" => 2145
        "mar_21_amount_percent" => 65
        "mar_22_amount" => 2402
        "mar_22_amount_percent" => 60
        "mar_23_amount" => 2654
        "mar_23_amount_percent" => 55
        "status*/
		
		\DB::table('product_concentrations')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$product_diversification = $row['product_diversification'];
			$mar_16_amount = $row['mar_16_amount'];
			$mar_16_amount_percent = $row['mar_16_amount_percent'];
			$mar_17_amount = $row['mar_17_amount'];
			$mar_17_amount_percent = $row['mar_17_amount_percent'];
			$mar_18_amount = $row['mar_18_amount'];
			$mar_18_amount_percent = $row['mar_18_amount_percent'];
			$mar_19_amount = $row['mar_19_amount'];
			$mar_19_amount_percent = $row['mar_19_amount_percent'];
			$mar_20_amount = $row['mar_20_amount'];
			$mar_20_amount_percent = $row['mar_20_amount_percent'];
			$sep_20_amount = $row['sep_20_amount'];
			$sep_20_amount_percent = $row['sep_20_amount_percent'];
			$mar_21_amount = $row['mar_21_amount'];
			$mar_21_amount_percent = $row['mar_21_amount_percent'];
			$mar_22_amount = $row['mar_22_amount'];
			$mar_22_amount_percent = $row['mar_22_amount_percent'];
			$mar_23_amount = $row['mar_23_amount'];
			$mar_23_amount_percent = $row['mar_23_amount_percent'];
			
			$lenderBanking = new ProductConcentration;
			$lenderBanking->product_diversification = $product_diversification;
			$lenderBanking->amount1 = $mar_16_amount;
			$lenderBanking->amount_percentage1 = $mar_16_amount_percent;
			$lenderBanking->amount2 = $mar_17_amount;
			$lenderBanking->amount_percentage2 = $mar_17_amount_percent;
			$lenderBanking->amount3 = $mar_18_amount;
			$lenderBanking->amount_percentage3 = $mar_18_amount_percent;
			$lenderBanking->amount4 = $mar_19_amount;
			$lenderBanking->amount_percentage4 = $mar_19_amount_percent;
			$lenderBanking->amount5 = $mar_20_amount;
			$lenderBanking->amount_percentage5 = $mar_20_amount_percent;
			$lenderBanking->amount6 = $sep_20_amount;
			$lenderBanking->amount_percentage6 = $sep_20_amount_percent;
			$lenderBanking->amount7 = $mar_21_amount;
			$lenderBanking->amount_percentage7 = $mar_21_amount_percent;
			$lenderBanking->amount8 = $mar_22_amount;
			$lenderBanking->amount_percentage8 = $mar_22_amount_percent;
			$lenderBanking->amount9 = $mar_23_amount;
			$lenderBanking->amount_percentage9 = $mar_23_amount_percent;


			$lenderBanking->product_concentration_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'product_diversification' => 'required',
            'mar_16_amount' => 'required',
            'mar_16_amount_percent' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'product_diversification' => 'Message 2.',
			'mar_16_amount' => 'Message 3.',
			'mar_16_amount_percent' => 'Message 4.',
            'status' => 'Message 20.',
		];
	}
	
}
