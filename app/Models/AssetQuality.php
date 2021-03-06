<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class AssetQuality extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'asset_quality';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['geographical_diversification', 'amount1', 'amount_percentage1', 'amount2', 'amount_percentage2', 'amount3',     'amount_percentage3', 'amount4', 'amount_percentage4', 'amount5', 'amount_percentage5', 'amount6', 'amount_percentage6', 'amount7', 'amount_percentage7', 'amount8', 'amount_percentage8'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportAssetQualityButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Asset Quality'  href='".backpack_url('exportAssetQuality')."'><i class='fa fa-download'></i> Export Asset Quality </a> &nbsp;&nbsp;"; 
    }
    
    public function importAssetQualityButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Asset Quality'  href='".backpack_url('importAssetQuality')."'><i class='fa fa-cloud'></i> Import Asset Quality </a> &nbsp;&nbsp;"; 
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
