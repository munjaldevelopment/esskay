<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductConcentrationImport implements WithMultipleSheets
{
	public function sheets(): array
    {
        return [
            0 => new ProductConcentrationSheetImport()
        ];
    }	
}
