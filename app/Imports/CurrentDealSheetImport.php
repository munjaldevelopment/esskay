<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\CurrentDealCategory;
use App\Models\CurrentDeal;

use Auth;

class CurrentDealSheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		//dd($rows);
		/*category" => "PTC"
        "deal_code" => "ICICI1"
        "name" => "ICICI Bank"
        "rating" => "AA+"
        "amount" => 75
        "pricing" => 9.75
        "tenure" => "2 Years 3 Months"
        "status"*/
		
		\DB::table('current_deals')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			$category = $row['category'];
			$deal_code = $row['deal_code'];
			$name = $row['name'];
			$rating = $row['rating'];
			$amount = $row['amount'];
			$pricing = $row['pricing'];
			$tenure = $row['tenure'];

			$current_deal_category_id = 0;

			$dealCat = CurrentDealCategory::where('category_code', $category)->first();
			if($dealCat)
			{
				$current_deal_category_id = $dealCat->id;
			}


			$lenderBanking = new CurrentDeal;
			$lenderBanking->current_deal_category_id = $current_deal_category_id;
			$lenderBanking->current_deal_code = $deal_code;
			$lenderBanking->name = $name;
			$lenderBanking->rating = $rating;
			$lenderBanking->amount = $amount;
			$lenderBanking->pricing = $pricing;
			$lenderBanking->tenure = $tenure;

			$lenderBanking->status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
			'category' => 'required',
			'deal_code' => 'required',
			'name' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'category' => 'Message 2.',
			'deal_code' => 'Message 3.',
			'name' => 'Message 4.',
            'status' => 'Message 9.',
		];
	}
	
}
