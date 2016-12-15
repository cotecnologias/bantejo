<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	protected $fillable = ['name','lastname','iduser','idoccupation',];

	protected $hidden = [
        'deleted_at', 
    ];
	protected $dates = ['deleted_at',];

}
