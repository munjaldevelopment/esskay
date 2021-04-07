<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\CollectionEfficiency;

class CollectionEfficiencySheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Heading Top Graph',
            'Amount Top Graph',
            'Heading Bottom Graph',
            'Amount Bottom Graph',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = CollectionEfficiency::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Heading Top Graph' => $factory['heading_graph1'],
		            'Amount Top Graph' => $factory['amount_graph1'],
		            'Heading Bottom Graph' => $factory['heading_graph2'],
		            'Amount Bottom Graph' => $factory['amount_graph2'],
		            'Status' => ($factory['collection_efficiency_status'] ? "Yes" : "No"));
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
