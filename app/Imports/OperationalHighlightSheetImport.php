<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\OperationalHighlight;

use Auth;

class OperationalHighlightSheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*"value1_amount" => 381
        "value1_heading" => "Total Income"
        "value1_heading_percentage" => 52.75
        "value1_year" => 2019
        "value2_amount" => 582
        "value2_heading" => "Total Income"
        "value2_heading_percentage" => 52.75
        "value2_year" => 2020
        "value3_amount" => 582
        "status"*/
		
		\DB::table('operational_highlights')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$operational_highlights_id = $row['id'];
			$operation_row1_value = $row['value1_amount'];
			$operation_row1_income = $row['value1_heading'];
			$operation_row1_income_percentage = $row['value1_heading_percentage'];
			$operation_row1_year = $row['value1_year'];
			$operation_row2_value = $row['value2_amount'];
			$operation_row2_income = $row['value2_heading'];
			$operation_row2_income_percentage = $row['value2_heading_percentage'];
			$operation_row2_year = $row['value2_year'];
			$operation_row3_value = $row['value3_amount'];
			$operation_row3_year = $row['value3_year'];
			
			$lenderBanking = new OperationalHighlight;
			$lenderBanking->operation_row1_value = $operation_row1_value;
			$lenderBanking->operation_row1_income = $operation_row1_income;
			$lenderBanking->operation_row1_income_percentage = $operation_row1_income_percentage;
			$lenderBanking->operation_row1_year = $operation_row1_year;
			$lenderBanking->operation_row2_value = $operation_row2_value;
			$lenderBanking->operation_row2_income = $operation_row2_income;
			$lenderBanking->operation_row2_income_percentage = $operation_row2_income_percentage;
			$lenderBanking->operation_row2_year = $operation_row2_year;
			$lenderBanking->operation_row3_value = $operation_row3_value;
			$lenderBanking->operation_row3_year = $operation_row3_year;
			$lenderBanking->operational_highlight_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'value1_amount' => 'required',
            'value1_heading' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'operation_row1_value' => 'Message 2.',
			'value1_heading' => 'Message 3.',
            'status' => 'Message 4.',
		];
	}
	
}
