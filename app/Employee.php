<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name','last_name', 'user_id', 'company_id', 'phone', 'staffId', 'address'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function departments()
    {
        return $this->belongsToMany('App\Department');
    }
}
