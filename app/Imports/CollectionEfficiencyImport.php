<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CollectionEfficiencyImport implements WithMultipleSheets
{
	public function sheets(): array
    {
        return [
            0 => new CollectionEfficiencySheetImport()
        ];
    }	
}