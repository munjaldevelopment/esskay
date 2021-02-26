<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'documents';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['document_category_id', 'document_sub_category_id', 'document_heading', 'document_name', 'document_guide', 'document_filename', 'document_date', 'expiry_date', 'document_status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function documentCategory()
	{
		return $this->belongsTo('App\Models\DocumentCategory', 'document_category_id');
	}
	
	public function documentSubCategory()
	{
		return $this->belongsTo('App\Models\DocumentCategory', 'document_sub_category_id');
	}

    public function lenders1()
    {
        return $this->belongsTo('App\Models\Lender', 'lender_id');
    }

     public function lenders()
    {
        return $this->belongsToMany('App\Models\Lender', 'document_lender');
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
