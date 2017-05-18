<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_dayoff extends Model
{
    protected $table 		= 'user_dayoff';

    protected $primaryKey	= 'id';

    public $timestamps = true;

    public function provision(){
    	return $this->hasMany('App\Provision','id','provision_id');
    }
    public function provision_way(){
    	// return $this->belongsTo('App\Provision_way','provision_way_id','id');
    	return $this->hasMany('App\Provision_way','id','provision_way_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
