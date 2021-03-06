<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class GeographicalConcentration extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geographical_concentrations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['geographical_diversification', 'docp', 'amount1', 'amount_percentage1', 'amount2', 'amount_percentage2', 'amount3',     'amount_percentage3', 'amount4', 'amount_percentage4', 'amount5', 'amount_percentage5', 'amount6', 'amount_percentage6', 'amount7', 'amount_percentage7', 'amount8', 'amount_percentage8', 'amount9', 'amount_percentage9'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportGeographicalConcentrationButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Geographical Concentration'  href='".backpack_url('exportGeographicalConcentration')."'><i class='fa fa-download'></i> Export Geographical Concentration </a> &nbsp;&nbsp;"; 
    }
    
    public function importGeographicalConcentrationButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Geographical Concentration'  href='".backpack_url('importGeographicalConcentration')."'><i class='fa fa-cloud'></i> Import Geographical Concentration </a> &nbsp;&nbsp;"; 
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
