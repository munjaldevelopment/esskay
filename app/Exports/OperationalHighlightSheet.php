<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\OperationalHighlight;

class OperationalHighlightSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Value1 Amount',
            'Value1 Heading',
            'Value2 Amount',
            'Value2 Heading',
            'Value3 Amount',
        ];
    }
	
	public function array(): array
    {
		$factories = OperationalHighlight::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory){
				$factoryData[$k] = array('ID' => $factory['id'], 'Value1 Amount' => $factory['operation_row1_value'], 'Value1 Heading' => $factory['operation_row1_income'], 'Value2 Amount' => $factory['operation_row2_value'], 'Value2 Heading' => $factory['operation_row2_income'], 'Value3 Amount' => $factory['operation_row3_value']);
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Operational Highlight";
	}
}
