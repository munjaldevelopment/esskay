<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\AssetQuality;

use Auth;

class AssetQualitySheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*geographical_diversification" => "Assets1"
        "fy14_amount_percent" => 2.59
        "fy15_amount_percent" => 2.12
        "fy16_amount_percent" => 1.68
        "fy17_amount_percent" => 2.62
        "fy18_amount_percent" => 2.39
        "fy19_amount_percent" => 2.28
        "fy20_amount_percent" => 2.3
        "fy21_amount_percent" => 1.97
        "status"*/
		
		\DB::table('asset_quality')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$geographical_diversification = $row['geographical_diversification'];
			$fy14_amount_percent = $row['fy14_amount_percent'];
			$fy15_amount_percent = $row['fy15_amount_percent'];
			$fy16_amount_percent = $row['fy16_amount_percent'];
			$fy17_amount_percent = $row['fy17_amount_percent'];
			$fy18_amount_percent = $row['fy18_amount_percent'];
			$fy19_amount_percent = $row['fy19_amount_percent'];
			$fy20_amount_percent = $row['fy20_amount_percent'];
			$fy21_amount_percent = $row['fy21_amount_percent'];
			
			$lenderBanking = new AssetQuality;
			$lenderBanking->geographical_diversification = $geographical_diversification;
			$lenderBanking->amount_percentage1 = $fy14_amount_percent;
			$lenderBanking->amount_percentage2 = $fy15_amount_percent;
			$lenderBanking->amount_percentage3 = $fy16_amount_percent;
			$lenderBanking->amount_percentage4 = $fy17_amount_percent;
			$lenderBanking->amount_percentage5 = $fy18_amount_percent;
			$lenderBanking->amount_percentage6 = $fy19_amount_percent;
			$lenderBanking->amount_percentage7 = $fy20_amount_percent;
			$lenderBanking->amount_percentage8 = $fy21_amount_percent;

			$lenderBanking->asset_quality_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'geographical_diversification' => 'required',
            'fy14_amount_percent' => 'required',
            'fy15_amount_percent' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'geographical_diversification' => 'Message 2.',
			'fy14_amount_percent' => 'Message 3.',
			'fy15_amount_percent' => 'Message 4.',
            'status' => 'Message 11.',
		];
	}
	
}
