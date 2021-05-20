<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class StrongLiabilityProfileTable extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'strong_liability_profile_tables';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['lender', 'amount1', 'amount1_lender', 'amount2', 'amount2_lender', 'amount3', 'amount3_lender', 'amount4', 'amount4_lender', 'amount5', 'amount5_lender', 'amount6', 'amount6_lender', 'amount7', 'amount7_lender', 'strong_liability_table_status'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportStrongLiabilityTableButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Strong Liability Table'  href='".backpack_url('exportStrongLiabilityTable')."'><i class='fa fa-download'></i> Export Strong Liability Table</a> &nbsp;&nbsp;"; 
    }
    
    public function importStrongLiabilityTableButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Strong Liability Table'  href='".backpack_url('importStrongLiabilityTable')."'><i class='fa fa-cloud'></i> Import Strong Liability Table</a> &nbsp;&nbsp;"; 
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
