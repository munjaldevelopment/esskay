<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\Liquidity;

class LiquiditySheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Quarter on Quarter Liquidity',
            'Dec-18',
            'Mar-19',
            'Jun-19',
            'Sep-19',
            'Dec-19',
            'Mar-20',
            'Jun-20',
            'Sep-20',
            'Nov-20',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = Liquidity::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Quarter on Quarter Liquidity' => $factory['quarter'],
		            'Dec-18' => $factory['amount1'],
		            'Mar-19' => $factory['amount2'],
		            'Jun-19' => $factory['amount3'],
		            'Sep-19' => $factory['amount4'],
		            'Dec-19' => $factory['amount5'],
		            'Mar-20' => $factory['amount6'],
		            'Jun-20' => $factory['amount7'],
		            'Sep-20' => $factory['amount8'],
		            'Nov-20' => $factory['amount9'],
		            'Status' => ($factory['liquidity_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Liquidity";
	}
}
