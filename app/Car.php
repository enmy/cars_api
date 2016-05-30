<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand', 'model', 'color', 'year', 'price', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function user_wish()
    {
        return $this->belongsToMany('App\User','wishs')->withTimestamps();
    }

}
