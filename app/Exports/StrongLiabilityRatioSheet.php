<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\StrongLiabilityProfileRatio;

class StrongLiabilityRatioSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Financial Year',
            'Branches',
			'Employee Strength',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = StrongLiabilityProfileRatio::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);

		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Financial Year' => $factory['financial_year'],
					'Branches' => $factory['amount1'],
					'Employee Strength' => $factory['amount2'],
		            'Status' => ($factory['strong_liability_ratio_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Strong Liability Profile Ratio";
	}
}
