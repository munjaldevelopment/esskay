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
		dd($rows);
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
			$operation_row1_value = $row['operation_row1_value'];
			$operation_row1_income = $row['operation_row1_income'];
			$operation_row2_value = $row['operation_row2_value'];
			$operation_row2_income = $row['operation_row2_income'];
			$operation_row3_value = $row['operation_row3_value'];
			
			$lenderBanking = new OperationalHighlight;
			$lenderBanking->id = $operational_highlights_id;
			$lenderBanking->operation_row1_value = $operation_row1_value;
			$lenderBanking->operation_row1_income = $operation_row1_income;
			$lenderBanking->operation_row2_value = $operation_row2_value;
			$lenderBanking->operation_row2_income = $operation_row2_income;
			$lenderBanking->operation_row3_value = $operation_row3_value;
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'operation_row1_value' => 'required',
            'operation_row1_income' => 'required'
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'operation_row1_value' => 'Message 2.',
			'operation_row1_income' => 'Message 3.',
		];
	}
	
}
