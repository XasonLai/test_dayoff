<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name','english_name','staff_id','first_day_company' ,'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public $timestamps = true;

    public  $staff_list = array(
            0 => '一般',
            1 => '主管',
            2 => '超級主管',
        );
    public $check_list = array(
    		0 => '未核對',
    		1 => '已核對',
    		2 => '全部',
    	);

    public function user_dayoff(){
    	return $this->hasMany('App\User_dayoff','user_id','id');
    }

    public function compensatory(){
    	return $this->hasMany('App\Compensatory','user_id','id');
    }

    public function annual_leave(){
    	return $this->hasMany('App\Annual_leave','user_id','id');
    }

    public function count_dayoff($item){

    	$sum = 0;
    	foreach ($item as $key => $value) {
    		$x = Self::count_each($value);    		
    		$sum = $sum + $x;	    	
    	}
    	
		return $sum;
    }

    public function count_each($time){

    	$value = $time ;
    	$dayoff_total = 0;
    	$dayoff_hour = 0;
    	if($value->minutes == 30){
			$dayoff_hour = $value->hours+0.5;
		}else{
			$dayoff_hour = $value->hours;
		}
		$dayoff_total = ($value->days) * 8 + $dayoff_hour + $dayoff_total;

		return $dayoff_total;

    }

}
