<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\StrongLiabilityProfileTable;

class StrongLiabilityTableSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Lender',
			'Mar-16 Amount',
			'Mar-16 Lenders',
			'Mar-17 Amount',
			'Mar-17 Lenders',
			'Mar-18 Amount',
			'Mar-18 Lenders',
			'Mar-19 Amount',
			'Mar-19 Lenders',
			'Mar-20 Amount',
			'Mar-20 Lenders',
			'Nov-20 Amount',
			'Nov-20 Lenders',
            'Status',
        ];
    }

	
	public function array(): array
    {
		$factories = StrongLiabilityProfileTable::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Lender' => $factory['lender'],
					'Mar-16 Amount' => $factory['amount1'],
					'Mar-16 Lenders' => $factory['amount1_lender'],
					'Mar-17 Amount' => $factory['amount2'],
					'Mar-17 Lenders' => $factory['amount2_lender'],
					'Mar-18 Amount' => $factory['amount3'],
					'Mar-18 Lenders' => $factory['amount3_lender'],
					'Mar-19 Amount' => $factory['amount4'],
					'Mar-19 Lenders' => $factory['amount4_lender'],
					'Mar-20 Amount' => $factory['amount5'],
					'Mar-20 Lenders' => $factory['amount5_lender'],
					'Nov-20 Amount' => $factory['amount6'],
					'Nov-20 Lenders' => $factory['amount6_lender'],
		            'Status' => ($factory['strong_liability_table_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Strong Liability Table";
	}
}
