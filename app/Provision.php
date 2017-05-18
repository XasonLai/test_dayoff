<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provision extends Model
{
    protected $table = 'provision';

    protected $primaryKey = 'id';

    public $provision_reason = array(

    		1	=> '婚假',
			2	=> '事假',
			3	=> '病假',
			4	=> '喪假',
			5	=> '公假',
			6	=> '補休',
			7	=> '特休',
			8	=> '陪產假',
			9	=> '產假',
			10	=> '其他',

    	);

    // public function provision_way(){
    // 	return $this->hasMany('App\Provision_way','provision_id','id');
    // }

}
