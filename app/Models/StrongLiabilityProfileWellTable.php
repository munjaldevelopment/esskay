<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class StrongLiabilityProfileWellTable extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'strong_liability_profile_well_table';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['particulars', 'amount1', 'amount2', 'amount3', 'amount4',  'amount5',  'amount6',  'amount7', 'amount8',  'amount9', 'strong_liability_well_status'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |---------------------------------s-----------------------------------------
    */
    public function exportStrongLiabilityWellTableButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Strong Liability WellTable'  href='".backpack_url('exportStrongLiabilityWellTable')."'><i class='fa fa-download'></i> Export Strong Liability WellTable</a> &nbsp;&nbsp;"; 
    }
    
    public function importStrongLiabilityWellTableButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Strong Liability WellTable'  href='".backpack_url('importStrongLiabilityWellTable')."'><i class='fa fa-cloud'></i> Import Strong Liability WellTable</a> &nbsp;&nbsp;"; 
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
