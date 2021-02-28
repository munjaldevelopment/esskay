<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\LenderBankingDetail;

class LenderBankingDetailSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
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
            'Lender Banking Detail Code',
            'Banking Arrangment',
            'Banking Date',
            'Sanction',
            'Outstanding',
            'Status',
        ];
    }
	
	public function array(): array
    {
		$factories = LenderBankingDetail::leftjoin('lender_banking', 'lender_banking_details.lender_banking_id', '=', 'lender_banking.id')->leftjoin('lenders', 'lender_banking_details.lender_id', '=', 'lenders.id')->leftjoin('banking_arrangment', 'lender_banking_details.banking_arrangment_id', '=', 'banking_arrangment.id')->selectRaw('lender_banking_details.id as lender_banking_id, lenders.name as lender_name, lender_banking_details.lender_banking_detail_code, lender_banking.lender_banking_code, banking_arrangment.name as banking_arrangment_name, lender_banking_details.lender_banking_date, lender_banking_details.sanction_amount, lender_banking_details.sanction_amount, lender_banking_details.outstanding_amount, lender_banking_details.lender_banking_status')->orderBy('lender_banking_details.id', 'ASC')->get()->toArray();
		//dd($factories);
		$factoryData = array();
		if($factories){
			foreach($factories as $k => $factory){
				$factoryData[$k] = array('ID' => $factory['lender_banking_id'], 'Lender' => $factory['lender_name'], 'Lender Banking Code' => $factory['lender_banking_code'], 'Lender Banking Detail Code' => $factory['lender_banking_detail_code'], 'Banking Arrangment' => $factory['banking_arrangment_name'], 'Banking Date' => $factory['lender_banking_date'], 'Sanction' => $factory['sanction_amount'], 'Outstanding' => $factory['outstanding_amount'], 'Status' => ($factory['lender_banking_status'] ? "Yes" : "No"));
			}
		}
		
		//dd($factoryData);
		
        return $factoryData;
	}
	
	public function title(): string
    {
		return "Lender Banking Detail";
	}
}
