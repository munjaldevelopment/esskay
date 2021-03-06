<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class LenderBanking extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'lender_banking';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['lender_id', 'lender_banking_code', 'banking_arrangment_id', 'sanction_amount', 'outstanding_amount','lender_banking_status'];
    // protected $hidden = [];
    // protected $dates = [];

    
    public function getAmountAttribute()
    {
        return "{$this->sanction_amount} {$this->outstanding_amount}";
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function lenders()
	{
		return $this->belongsTo('App\Models\Lender', 'lender_id');
	}
	
	public function bankingArrangment()
	{
		return $this->belongsTo('App\Models\BankingArrangment', 'banking_arrangment_id');
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
	public function exportLenderBankingButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Lender Banking'  href='".backpack_url('exportLenderBanking')."'><i class='fa fa-download'></i> Export Lender Banking </a> &nbsp;&nbsp;"; 
    }
    
    public function importLenderBankingButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Lender Banking'  href='".backpack_url('importLenderBanking')."'><i class='fa fa-cloud'></i> Import Lender Banking </a> &nbsp;&nbsp;"; 
    }
}
