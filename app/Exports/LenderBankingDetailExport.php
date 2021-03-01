<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class LenderBankingDetailExport implements WithMultipleSheets
{
	use Exportable;
	
	public function __construct()
    {
		
    }
	
	public function collection()
    {
		
	}
	
	public function sheets(): array
    {
		$sheets = array();
		
		$sheets[] = new LenderBankingDetailSheet();

        return $sheets;
	}

	
}