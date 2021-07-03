<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class InsightLocation extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'insight_locations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['district_id', 'location_hub', 'branch_name', 'branch_type', 'branch_address', 'office_lat', 'office_long', 'status']; //'amount4', 
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function districts()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
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
