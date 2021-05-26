<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\StrongLiabilityProfile;

class StrongLiabilitySheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Quarter',
            'Bank/FI',
            'CME From MF',
            'Others',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = StrongLiabilityProfile::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Quarter' => $factory['quarter'],
		            'Bank/FI' => $factory['amount1'],
		            'CME From MF' => $factory['amount2'],
		            'Others' => $factory['amount3'],
		            'Status' => ($factory['strong_liability_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Strong Liability";
	}
}
