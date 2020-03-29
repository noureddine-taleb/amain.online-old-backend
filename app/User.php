<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
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

        static::deleting(function($user) {
            foreach ($user->bills() as $bill) {
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
        return $this->hasMany(Bill::class)->get();
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
            "image" => "required",
            "dob" => "required|date",
            "phone" => "required|max:255",
            "privileges" => "nullable|min:1|max:3",
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
            "image" => "required",
            "dob" => "required|date",
            "phone" => "required|max:255",
            "privileges" => "nullable|min:1|max:3",
        ];

    }
}
