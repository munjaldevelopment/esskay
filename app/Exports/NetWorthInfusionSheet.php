<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\NetWorth;

class NetWorthInfusionSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Particulars',
            'Top FY16 Amount',
			'Top FY17 Amount',
			'Top FY18 Amount',
			'Top FY19 Amount',
			'Top FY20 Amount',
			'Top FY21 Amount',
			'Bottom FY16 Amount',
			'Bottom FY17 Amount',
			'Bottom FY18 Amount',
			'Bottom FY19 Amount',
			'Bottom FY20 Amount',
			'Bottom FY21 Amount',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = NetWorth::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Particulars' => $factory['particulars'],
					'Top FY16 Amount' => $factory['amount1'],
					'Top FY17 Amount' => $factory['amount2'],
					'Top FY18 Amount' => $factory['amount3'],
					'Top FY19 Amount' => $factory['amount4'],
					'Top FY20 Amount' => $factory['amount5'],
					'Top FY21 Amount' => $factory['amount6'],
					'Bottom FY16 Amount' => $factory['amount7'],
					'Bottom FY17 Amount' => $factory['amount8'],
					'Bottom FY18 Amount' => $factory['amount9'],
					'Bottom FY19 Amount' => $factory['amount10'],
					'Bottom FY20 Amount' => $factory['amount11'],
					'Bottom FY21 Amount' => $factory['amount12'],
		            'Status' => ($factory['net_worth_status'] ? "Yes" : "No"));
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
