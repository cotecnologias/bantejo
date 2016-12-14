<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	protected $fillable = ['show','insert','edit','delete','report','iduser','idpage',];
	protected $hidden = [
        'deleted_at', 
    ];

	protected $dates = ['deleted_at',];

}
