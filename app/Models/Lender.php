<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class Lender extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'lenders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
	
    protected $fillable = ['name', 'email','phone', 'password', 'user_id', 'is_banking_arrangement', 'is_message_md', 'is_insight', 'is_current_deal', 'is_document', 'is_financial_summary', 'is_newsletter', 'is_contact_us', 'is_onboard']; //
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	/*public function lenderType()
	{
		return $this->belongsTo('App\Models\LenderType', 'lender_type_id');
	}
	
	public function instrumentType()
	{
		return $this->belongsTo('App\Models\InstrumentType', 'instrument_type_id');
	}
	
	public function facilityType()
	{
		return $this->belongsTo('App\Models\FacilityType', 'facility_type_id');
	}*/
	
	public function users()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function identifiableName()
    {
        return $this->name;
    }

    // If you are using another bootable trait
    // be sure to override the boot method in your model
    public static function boot()
    {
        parent::boot();
    }

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
