<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

 	protected $fillable = ['name'];

    public function employees(){
    	return $this->hasMany('App\Department');
    }
}
