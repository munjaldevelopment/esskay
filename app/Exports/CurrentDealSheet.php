<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\CurrentDealCategory;
use App\Models\CurrentDeal;

class CurrentDealSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Deal Code',
            'Name',
            'Rating',
            'Amount',
            'Pricing',
            'Tenure',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = CurrentDeal::orderBy('id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory)
			{
				$current_deal_category = "";
				$dealCat = CurrentDealCategory::find($factory['current_deal_category_id']);
				if($dealCat)
				{
					$current_deal_category = $dealCat->category_code;
				}

				$factoryData[$k] = array(
					'ID' => $factory['id'],
					'Category' => $current_deal_category,
		            'Deal Code' => $factory['current_deal_code'],
		            'Name' => $factory['name'],
		            'Rating' => $factory['rating'],
		            'Amount' => $factory['amount'],
		            'Pricing' => $factory['pricing'],
		            'Tenure' => $factory['tenure'],
		            'Status' => ($factory['status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "CurrentDeal";
	}
}
