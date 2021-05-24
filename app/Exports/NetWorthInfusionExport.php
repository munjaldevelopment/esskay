<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class NetWorthInfusionExport implements WithMultipleSheets
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
		
		$sheets[] = new NetWorthInfusionSheet();

        return $sheets;
	}

	
}