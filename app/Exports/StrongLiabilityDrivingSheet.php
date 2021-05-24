<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\StrongLiabilityProfileDriving;

class StrongLiabilityDrivingSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Financial Year',
            'Tier1',
			'Tier2',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = StrongLiabilityProfileDriving::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);

		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Financial Year' => $factory['financial_year'],
					'Tier1' => $factory['amount1'],
					'Tier2' => $factory['amount2'],
		            'Status' => ($factory['strong_liability_driving_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Strong Liability Profile Driving";
	}
}
