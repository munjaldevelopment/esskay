<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\StrongLiabilityProfileWellTable;

class StrongLiabilityWellTableSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Particulars',
            'As per IGAAP FY16',
			'As per IGAAP FY17',
			'As per IGAAP FY18',
			'As per IND AS FY16',
			'As per IND AS FY17',
			'As per IND AS FY18',
			'As per IGAAP FY21',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = StrongLiabilityProfileWellTable::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);

		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Particulars' => $factory['particulars'],
					'As per IGAAP FY16' => $factory['amount1'],
					'As per IGAAP FY17' => $factory['amount2'],
					'As per IGAAP FY18' => $factory['amount3'],
					'As per IND AS FY16' => $factory['amount4'],
					'As per IND AS FY17' => $factory['amount5'],
					'As per IND AS FY18' => $factory['amount6'],
					'As per IGAAP FY21' => $factory['amount7'],
		            'Status' => ($factory['strong_liability_well_status'] ? "Yes" : "No"));
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
