<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\AssetQuality;

class AssetQualitySheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Geographical Diversification',
            'FY14 Amount Percent',
            'FY15 Amount Percent',
            'FY16 Amount Percent',
            'FY17 Amount Percent',
            'FY18 Amount Percent',
            'FY19 Amount Percent',
            'FY20 Amount Percent',
            'FY21 Amount Percent',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = AssetQuality::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Product Diversification' => $factory['geographical_diversification'],
					'FY14 Amount Percent' => $factory['amount_percentage1'],
		            'FY15 Amount Percent' => $factory['amount_percentage2'],
		            'FY16 Amount Percent' => $factory['amount_percentage3'],
		            'FY17 Amount Percent' => $factory['amount_percentage4'],
		            'FY18 Amount Percent' => $factory['amount_percentage5'],
		            'FY19 Amount Percent' => $factory['amount_percentage6'],
		            'FY20 Amount Percent' => $factory['amount_percentage7'],
		            'FY21 Amount Percent' => $factory['amount_percentage8'],
		            'Status' => ($factory['asset_quality_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Asset Quality";
	}
}
