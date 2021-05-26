<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\NetWorthInfusion;

class NetWorthInfusionSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Month',
            'Capital Infusion',
			'Investors',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = NetWorthInfusion::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Month' => $factory['month'],
					'Capital Infusion' => $factory['capital_infusion'],
					'Investors' => $factory['investors'],
		            'Status' => ($factory['net_worth_infusion_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Net Worth";
	}
}
