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
            'Value1 Heading Percentage',
            'Value1 Year',
            'Value2 Amount',
            'Value2 Heading',
            'Value2 Heading Percentage',
            'Value2 Year',
            'Value3 Amount',
            'Value3 Year',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = OperationalHighlight::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array('ID' => $factory['id'], 'Value1 Amount' => $factory['operation_row1_value'], 'Value1 Heading' => $factory['operation_row1_income'], 'Value1 Heading Percentage' => $factory['operation_row1_income_percentage'], 'Value1 Year' => $factory['operation_row1_year'], 'Value2 Amount' => $factory['operation_row2_value'], 'Value2 Heading' => $factory['operation_row2_income'], 'Value2 Heading  Percentage' => $factory['operation_row2_income_percentage'], 'Value2 Year' => $factory['operation_row2_year'], 'Value3 Amount' => $factory['operation_row3_value'], 'Value3 Year' => $factory['operation_row3_year'], 'Status' => ($factory['operational_highlight_status'] ? "Yes" : "No"));
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
