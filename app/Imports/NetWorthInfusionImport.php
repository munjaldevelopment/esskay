<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\NetWorthInfusion;

use Auth;

class NetWorthInfusionImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*particulars" => "Opening Net worth"
        "top_fy16_amount" => 61.96
        "top_fy17_amount" => 73.97
        "top_fy18_amount" => 86.27
        "top_fy19_amount" => 206.3
        "top_fy20_amount" => 555.18
        "top_fy21_amount" => 878.73
        "bottom_fy16_amount" => 5.7
        "bottom_fy17_amount" => 7.12
        "bottom_fy18_amount" => 4.35
        "bottom_fy19_amount" => 2.34
        "bottom_fy20_amount" => 2.92
        "bottom_fy21_amount" => 2.58
        "status"*/
		
		\DB::table('net_worth_infusions')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$month = $row['month'];
			$capital_infusion = $row['capital_infusion'];
			$investors = $row['investors'];

			$lenderBanking = new NetWorthInfusion;
			$lenderBanking->month = $month;
			$lenderBanking->capital_infusion = $capital_infusion;
			$lenderBanking->investors = $investors;

			$lenderBanking->net_worth_infusion_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'month' => 'required',
			'capital_infusion' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'month' => 'Message 2.',
			'capital_infusion' => 'Message 3.',
            'status' => 'Message 4.',
		];
	}
	
}
