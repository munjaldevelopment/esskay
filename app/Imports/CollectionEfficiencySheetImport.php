<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use App\Models\CollectionEfficiency;

use Auth;

class CollectionEfficiencySheetImport implements ToCollection, WithValidation, WithHeadingRow
{
	use Importable;
	
	public function collection(Collection $rows)
	{
		/*geographical_diversification" => "Assets1"
        "heading_top_graph" => "FY 16"
        "amount_top_graph" => 98
        "heading_bottom_graph" => "FY 16"
        "amount_bottom_graph" => 98
        "status"*/
		
		\DB::table('collection_efficiency')->truncate();
		
		$user = Auth::user();
		$user_id = $user->id;
		
		foreach($rows as $row)
		{
			if($row['heading_top_graph'] > 0)
			{
				$UNIX_DATE = ($row['heading_top_graph'] - 25569) * 86400;
				$heading_graph1 = gmdate("M-Y", $UNIX_DATE);
			}
			else 
			{
				$heading_graph1 = $row['heading_top_graph'];
			}

			$amount_graph1 = $row['amount_top_graph'];

			if($row['heading_bottom_graph'] > 0)
			{
				$UNIX_DATE = ($row['heading_bottom_graph'] - 25569) * 86400;
				$heading_graph2 = gmdate("M-Y", $UNIX_DATE);
			}
			else 
			{
				$heading_graph2 = $row['heading_bottom_graph'];
			}

			$amount_graph2 = $row['amount_bottom_graph'];

			$lenderBanking = new CollectionEfficiency;
			$lenderBanking->heading_graph1 = $heading_graph1;
			$lenderBanking->amount_graph1 = $amount_graph1;
			$lenderBanking->heading_graph2 = $heading_graph2;
			$lenderBanking->amount_graph2 = $amount_graph2;

			$lenderBanking->collection_efficiency_status = ($row['status'] == "Yes" ? "1" : "0");
			$lenderBanking->save();
		}
    }	
	
	public function rules(): array
	{
		return [
			'id' => 'required',
            'heading_top_graph' => 'required',
            'amount_top_graph' => 'required',
            'heading_bottom_graph' => 'required',
            'amount_bottom_graph' => 'required',
            'status' => 'required',
		];
	}
	
	public function customValidationMessages()
	{
		return [
			'id' => 'Message 1.',
			'heading_top_graph' => 'Message 3.',
			'amount_top_graph' => 'Message 4.',
			'heading_bottom_graph' => 'Message 5.',
			'amount_bottom_graph' => 'Message 6.',
            'status' => 'Message 7.',
		];
	}
	
}
