<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
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

        static::deleting(function($bill) {

            $payment = $bill->payment();
            
            $payment && $payment->delete();
            
        });
    }   
    /**
    * Define relationship with payment model
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function payment()
    {
        return $this->hasOne(Payment::class)->first();
    }
    /**
    * Define relationship with project model
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function project()
    {
        return $this->belongsTo(Project::class)->first();
    }
    /**
    * Define relationship with user model
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
        return $this->belongsTo(User::class)->first();
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
            "project_id" => "required|exists:projects,id",
            "user_id"  => "required|exists:users,id",
            "weight"   => "required|integer",
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
            "user_id"  => "required|exists:users,id",
            "weight"   => "required|integer",
        ];

    }
}
