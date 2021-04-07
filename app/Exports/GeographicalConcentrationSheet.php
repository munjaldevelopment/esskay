<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\GeographicalConcentration;

class GeographicalConcentrationSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Geographical Diversification',
            'DOCP',
            'Mar-16 Amount',
            'Mar-16 Amount Percent',
            'Mar-17 Amount',
            'Mar-17 Amount Percent',
            'Mar-18 Amount',
            'Mar-18 Amount Percent',
            'Mar-19 Amount',
            'Mar-19 Amount Percent',
            'Mar-20 Amount',
            'Mar-20 Amount Percent',
            'Sep-20 Amount',
            'Sep-20 Amount Percent',
            'Mar-21 Amount',
            'Mar-21 Amount Percent',
            'Mar-22 Amount',
            'Mar-22 Amount Percent',
            'Mar-23 Amount',
            'Mar-23 Amount Percent',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = GeographicalConcentration::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Geographical Diversification' => $factory['geographical_diversification'],
		            'DOCP' => $factory['docp'],
		            'Mar-16 Amount' => $factory['amount1'],
		            'Mar-16 Amount Percent' => $factory['amount_percentage1'],
		            'Mar-17 Amount' => $factory['amount2'],
		            'Mar-17 Amount Percent' => $factory['amount_percentage2'],
		            'Mar-18 Amount' => $factory['amount3'],
		            'Mar-18 Amount Percent' => $factory['amount_percentage3'],
		            'Mar-19 Amount' => $factory['amount4'],
		            'Mar-19 Amount Percent' => $factory['amount_percentage4'],
		            'Mar-20 Amount' => $factory['amount5'],
		            'Mar-20 Amount Percent' => $factory['amount_percentage5'],
		            'Sep-20 Amount' => $factory['amount6'],
		            'Sep-20 Amount Percent' => $factory['amount_percentage6'],
		            'Mar-21 Amount' => $factory['amount7'],
		            'Mar-21 Amount Percent' => $factory['amount_percentage7'],
		            'Mar-22 Amount' => $factory['amount8'],
		            'Mar-22 Amount Percent' => $factory['amount_percentage8'],
		            'Mar-23 Amount' => $factory['amount9'],
		            'Mar-23 Amount Percent' => $factory['amount_percentage9'],
		            'Status' => ($factory['geographical_concentration_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Geographical Highlight";
	}
}
