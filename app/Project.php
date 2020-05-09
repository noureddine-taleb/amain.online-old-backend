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
            foreach ($project->bills() as $bill) {
                $bill->delete();
            }
        });
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
    public static function indexRules(){
        
        return [
            "page" => "nullable|integer|min:1",
            "page_size" => "nullable|integer|min:1",
        ];

    }
    /**
    * Define input rules
    *
    * @return array
    */
    public static function createRules(){
        
        return [
            "name" => "required|max:255",
            "desc" => "required|min:20",
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
