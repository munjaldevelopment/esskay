<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class SanctionLetter extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sanction_letters';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    
    protected $fillable = ['user_id', 'bank_name', 'sanction_date', 'type_facility', 'facility_amount', 'email_address', 'roi', 'all_incluside_roi', 'processing_fees', 'processing_fees_amount', 'arranger_fees', 'arranger_fees_amount', 'total_associated_cost', 'all_inclusive_cost', 'all_inclusive_cost', 'rationale_availing', 'rationale_availing', 'stamp_duty_fees', 'tenor', 'security_cover', 'cash_collateral', 'personal_guarantee', 'intermediary', 'sanction_letter', 'is_approve1', 'approve1_user', 'is_approve2', 'approve2_user', 'is_approve3', 'approve3_user', 'status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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
