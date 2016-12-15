<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

	protected $fillable = ['name', ];

	protected $hidden = [
        'deleted_at', 
    ];

    protected $dates = ['deleted_at',];

}
