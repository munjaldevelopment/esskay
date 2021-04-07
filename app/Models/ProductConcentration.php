<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class ProductConcentration extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_concentrations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['product_diversification', 'amount1', 'amount_percentage1', 'amount2', 'amount_percentage2', 'amount3',     'amount_percentage3', 'amount4', 'amount_percentage4', 'amount5', 'amount_percentage5', 'amount6', 'amount_percentage6', 'amount7', 'amount_percentage7', 'amount8', 'amount_percentage8', 'amount9', 'amount_percentage9', 'product_concentration_status'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportProductConcentrationButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Product Concentration'  href='".backpack_url('exportProductConcentration')."'><i class='fa fa-download'></i> Export Product Con. </a> &nbsp;&nbsp;"; 
    }
    
    public function importProductConcentrationButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Product Concentration'  href='".backpack_url('importProductConcentration')."'><i class='fa fa-cloud'></i> Import Product Con. </a> &nbsp;&nbsp;"; 
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
