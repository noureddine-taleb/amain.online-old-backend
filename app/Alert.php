<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['updated_at','created_at','deleted_at','id'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot() 
    {
        parent::boot();
    }   
    /**
    * Define relationship with project model
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function project()
    {
        return $this->belongsTo(Project::class)->first();
    }

        /**
    * Define input rules
    *
    * @return array
    */
    public static function createRules(){
        
        return [
            "project_id" => "required|exists:projects,id",
            "frequency"  => "required|integer|min:1|max:5",
            "priority"   => "required|integer",
        ];

    }
    /**
    * Define input rules
    *
    * @return array
    */
    public static function updateRules(){
        
        return [
            "project_id" => "required|exists:projects,id",
            "frequency"  => "required|integer|min:1|max:5",
            "priority"   => "required|integer",
        ];

    }
}
