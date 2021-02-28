<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\LenderBanking;

class LenderBankingSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
	
    public function __construct()
    {
		
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Lender',
            'Lender Banking Code',
            'Banking Arrangment',
            'Sanction',
            'Outstanding',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = LenderBanking::leftjoin('lenders', 'lender_banking.lender_id', '=', 'lenders.id')->leftjoin('banking_arrangment', 'lender_banking.banking_arrangment_id', '=', 'banking_arrangment.id')->selectRaw('lender_banking.id as lender_banking_id, lenders.name as lender_name, lender_banking.lender_banking_code, banking_arrangment.name as banking_arrangment_name, lender_banking.sanction_amount, lender_banking.sanction_amount, lender_banking.outstanding_amount, lender_banking.lender_banking_status')->orderBy('lender_banking.id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory){
				$factoryData[$k] = array('ID' => $factory['lender_banking_id'], 'Lender' => $factory['lender_name'],  'Lender Banking Code' => $factory['lender_banking_code'], 'Banking Arrangment' => $factory['banking_arrangment_name'], 'Sanction' => $factory['sanction_amount'], 'Outstanding' => $factory['outstanding_amount'], 'Status' => ($factory['lender_banking_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Lender Banking";
	}
}
