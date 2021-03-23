<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class OperationalHighlight extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'operational_highlights';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['operation_row1_value', 'operation_row1_income', 'operation_row1_income_percentage', 'operation_row1_year', 'operation_row2_value', 'operation_row2_income', 'operation_row2_income_percentage', 'operation_row2_year', 'operation_row3_value', 'operational_highlight_status', 'operation_row3_year'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportOperationalHighlightButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Op. Highlight'  href='".backpack_url('exportOperationalHighlight')."'><i class='fa fa-download'></i> Export Op. Highlight </a> &nbsp;&nbsp;"; 
    }
    
    public function importOperationalHighlightButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Op. Highlight'  href='".backpack_url('importOperationalHighlight')."'><i class='fa fa-cloud'></i> Import Op. Highlight </a> &nbsp;&nbsp;"; 
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
