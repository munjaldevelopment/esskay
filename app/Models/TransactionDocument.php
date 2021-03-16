<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class TransactionDocument extends Model
{
    use CrudTrait, RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transaction_documents';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['transaction_id', 'user_id', 'transaction_document_type_id', 'document_heading', 'document_type', 'document_name', 'document_filename', 'document_date', 'expiry_date', 'document_status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function transactionDocumentType()
    {
        return $this->belongsTo('App\Models\TransactionDocumentType', 'transaction_document_type_id');
    }
    

    public function trustees()
    {
        return $this->belongsToMany('App\Models\Trustee', 'transaction_document_trustee');
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
