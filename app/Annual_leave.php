<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Annual_leave extends Model
{
	use SoftDeletes;

    protected $table = 'annual_leave';

    protected $primaryKey	= 'id';

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public  $gov_list = array(
    	0 => "0日",
    	1 => "7日",
    	2 => "7日",
    	3 => "10日",
    	4 => "10日",
    	5 => "14日",
    	6 => "14日",
    	7 => "14日",
    	8 => "14日",
    	9 => "14日",
    	10 => "15日",
    	11 => "16日",
    	12 => "17日",
    	13 => "18日",
    	14 => "19日",
    	15 => "20日",
    	16 => "21日",
    	17 => "22日",
    	18 => "23日",
    	19 => "24日",
    	20 => "25日",
    	21 => "26日",
    	22 => "27日",
    	23 => "28日",
    	24 => "29日",
    	25 => "30日",

    	);
}
