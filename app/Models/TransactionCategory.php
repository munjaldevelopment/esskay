<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transaction_categories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    
    protected $fillable = ['category_code', 'category_name', 'is_timeline', 'category_icon', 'category_image', 'transaction_category_status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function trustees()
    {
        return $this->belongsToMany('App\Models\Trustee', 'transaction_category_trustee');
    }

    public function lenders()
    {
        return $this->belongsToMany('App\Models\Lender', 'transaction_category_lender');
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
