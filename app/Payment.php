<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
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
    }   
    /**
    * Define relationship with bill model
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function bill()
    {
        return $this->belongsTo(Bill::class)->first();
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
            "bill_id" => "required|exists:bills,id|unique:payments",
        ];

    }
    /**
    * Define input rules
    *
    * @return array
    */
    public static function updateRules(){
        
        return [
            "bill_id" => "required|exists:bills,id|unique:payments",
        ];

    }
}
