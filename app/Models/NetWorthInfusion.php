<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class NetWorthInfusion extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'net_worth_infusions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['month', 'capital_infusion', 'investors', 'net_worth_infusion_status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function exportNetWorthInfusionButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export NetWorth Infusion'  href='".backpack_url('exportNetWorthInfusion')."'><i class='fa fa-download'></i> Export NetWorth Infusion</a> &nbsp;&nbsp;"; 
    }
    
    public function importNetWorthInfusionButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import NetWorth Infusion'  href='".backpack_url('importNetWorthInfusion')."'><i class='fa fa-cloud'></i> Import NetWorth Infusion</a> &nbsp;&nbsp;"; 
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
