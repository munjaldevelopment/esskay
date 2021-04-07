<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\NetWorth;

use Auth;

class NetWorthSheetImport implements ToCollection, WithValidation, WithHeadingRow
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
		
		\DB::table('net_worth')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$particulars = $row['particulars'];
			$top_fy16_amount = $row['top_fy16_amount'];
			$top_fy17_amount = $row['top_fy17_amount'];
			$top_fy18_amount = $row['top_fy18_amount'];
			$top_fy19_amount = $row['top_fy19_amount'];
			$top_fy20_amount = $row['top_fy20_amount'];
			$top_fy21_amount = $row['top_fy21_amount'];

			$bottom_fy16_amount = $row['bottom_fy16_amount'];
			$bottom_fy17_amount = $row['bottom_fy17_amount'];
			$bottom_fy18_amount = $row['bottom_fy18_amount'];
			$bottom_fy19_amount = $row['bottom_fy19_amount'];
			$bottom_fy20_amount = $row['bottom_fy20_amount'];
			$bottom_fy21_amount = $row['bottom_fy21_amount'];

			$lenderBanking = new NetWorth;
			$lenderBanking->particulars = $particulars;
			$lenderBanking->amount1 = $top_fy16_amount;
			$lenderBanking->amount2 = $top_fy17_amount;
			$lenderBanking->amount3 = $top_fy18_amount;
			$lenderBanking->amount4 = $top_fy19_amount;
			$lenderBanking->amount5 = $top_fy20_amount;
			$lenderBanking->amount6 = $top_fy21_amount;

			$lenderBanking->amount7 = $bottom_fy16_amount;
			$lenderBanking->amount8 = $bottom_fy17_amount;
			$lenderBanking->amount9 = $bottom_fy18_amount;
			$lenderBanking->amount10 = $bottom_fy19_amount;
			$lenderBanking->amount11 = $bottom_fy20_amount;
			$lenderBanking->amount12 = $bottom_fy21_amount;

			$lenderBanking->net_worth_status = ($row['status'] == "Yes" ? "1" : "0");
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
            'status' => 'Message 15.',
		];
	}
	
}
