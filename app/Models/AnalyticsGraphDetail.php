<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class AnalyticsGraphDetail extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'analytics_graph_details';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
	protected $guarded = ['id'];
	protected $fillable = ['analytics_graph_id', 'graph_heading', 'graph_category','graph_value', 'graph_heading1', 'graph_category1','graph_value1',   'graph_heading2', 'graph_category2','graph_value2'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function analyticsGraph()
	{
		return $this->belongsTo('App\Models\AnalyticsGraph', 'analytics_graph_id');
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
