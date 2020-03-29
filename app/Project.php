<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $guarded = ['updated_at','created_at','deleted_at','id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    //
      /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($project) {
            foreach ($project->alerts() as $alert) {
                $alert->delete();
            }
            
            foreach ($project->bills() as $bill) {
                $bill->delete();
            }
        });
    }   
    /**
    * Define relationship with alert model
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function alerts()
    {
        return $this->hasMany('App\Alert')->get();
    }

    /**
    * Define relationship with bill model
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function bills()
    {
        return $this->hasMany('App\Bill')->get();
    }

    /**
    * Define input rules
    *
    * @return array
    */
    public static function createRules(){
        
        return [
            "name" => "required|max:255",
            "desc" => "required",
            "fees" => "required|numeric",
        ];

    }
    /**
    * Define input rules
    *
    * @return array
    */
    public static function updateRules(){
        
        return [
            "name" => "required|max:255",
            "desc" => "required",
            "fees" => "required|numeric",
        ];

    }
    
}
