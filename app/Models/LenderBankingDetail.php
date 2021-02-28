<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class LenderBankingDetail extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'lender_banking_details';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['lender_id', 'lender_banking_id', 'banking_arrangment_id', 'sanction_amount', 'outstanding_amount','lender_banking_status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function lenders()
	{
		return $this->belongsTo('App\Models\Lender', 'lender_id');
	}

    public function lenderBanking()
    {
        return $this->belongsTo('App\Models\LenderBanking', 'lender_banking_id');
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
	public function exportLenderBankingDetailButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Export Lender Banking'  href='".backpack_url('exportLenderBankingDetail')."'><i class='fa fa-download'></i> Export Lender Banking Detail</a> &nbsp;&nbsp;"; 
    }
    
    public function importLenderBankingDetailButton() {
        return "<a class='btn btn-success ladda-button tooltipped' data-position='right' data-delay='50' data-tooltip='Import Lender Banking'  href='".backpack_url('importLenderBankingDetail')."'><i class='fa fa-cloud'></i> Import Lender Banking Detail</a> &nbsp;&nbsp;"; 
    }
}
