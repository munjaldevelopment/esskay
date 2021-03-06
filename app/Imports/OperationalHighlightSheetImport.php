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
		/*lender" => "A K Capital Services Limited"
        "banking_arrangment" => "TL - Secured"
        "sanction" => 0.0
        "outstanding" => 0.0
        "status*/
		
		\DB::table('operational_highlights')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$operational_highlights_id = $row['id'];
			$operation_row1_value = $row['value1_amount'];
			$operation_row1_income = $row['value1_heading'];
			$operation_row2_value = $row['value2_amount'];
			$operation_row2_income = $row['value2_heading'];
			$operation_row3_value = $row['value3_amount'];
			
			$lenderBanking = new OperationalHighlight;
			$lenderBanking->id = $operational_highlights_id;
			$lenderBanking->operation_row1_value = $operation_row1_value;
			$lenderBanking->operation_row1_income = $operation_row1_income;
			$lenderBanking->operation_row2_value = $operation_row2_value;
			$lenderBanking->operation_row2_income = $operation_row2_income;
			$lenderBanking->operation_row3_value = $operation_row3_value;
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
