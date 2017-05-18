<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\User_dayoff;
use App\Annual_leave;
use App\Provision;
use App\Provision_way;
use App\Compensatory;
use App\Jobs\SendReminderEmail;
use App\Jobs\SendCheckEmail;
use Validator;

use Bllim\Datatables\Datatables;

class UserController extends Controller
{
   
    public function index(Request $request)
    {
    	
    	$user = new User;
    	$data['personal'] = \Auth::user();

    	$data['check_id'] = '';
    	if($request->has('check')){
    		$data['check_id'] = $request->input('check');
    		if( !isset($user->check_list[$data['check_id']] ) ){
    			return redirect('/staffs/user');
    		}

    		if( $data['check_id'] != 2 ){
    			$data['user_dayoff'] = $data['personal']->user_dayoff()
    								->where('check',$data['check_id'])
    								->orderBy('date_start')->get();

    			$data['user_compensatorys'] = $data['personal']->compensatory()
    									   ->where('check',$data['check_id'])
    									   ->orderBy('date')->get();	
    		}
    		else{
    			$data['user_dayoff'] = $data['personal']->user_dayoff()->orderBy('date_start')->get();
    			$data['user_compensatorys'] = $data['personal']->compensatory()->orderBy('date')->get();
    		}

    	}else{

    		$data['user_dayoff'] = $data['personal']->user_dayoff()->orderBy('date_start')->get();	
    		$data['user_compensatorys'] = $data['personal']->compensatory()->orderBy('date')->get();
    	}
    	
    	$provision = new Provision;
    	$data['provision_reason'] = $provision->provision_reason;

        // return view('user.user',$data);
        return view('user.index',$data); 
    }

    public function getIndex(Request $request){
    	$user_dayoff = new User_dayoff;
    	$dayoff = $user_dayoff->getTable();
    	$provision = new Provision;
    	$provision = $provision->getTable();

    	$user = \Auth::user()->id;

    	$check = $request->input('check');

    	$view_array = array(
    			$dayoff.'.id',
    			$dayoff.'.date_start',
    			$dayoff.'.date_end',
    			\DB::raw("CONCAT({$dayoff}.days, '天' ,{$dayoff}.hours , '小時' , {$dayoff}.minutes , '分鐘') "),
    			$dayoff.'.agent_name',
    			$provision.'.name',
    		);

    	$query = User_dayoff::select($view_array)
    						->leftjoin($provision , $provision.'.id' , '=' , $dayoff.'.provision_id')
    						->where($dayoff.'.user_id' ,'=' , $user)
    						->orderBy($dayoff.'.id' );
    	if($check != 2) $query = $query->where($dayoff.'.check' , '=' , $check);

    	$data = Datatables::of($query)
    						->make();

    	return $data;

    }

    public function show(Request $request){
    	dd(1);
    }


    public function create()
    {
    	$data['personal'] 	= \Auth::user();
    	$provision = Provision::all();
    	$data['provision'] = [];
    	foreach ($provision as $key => $value) {
    		$data['provision'][$value->id] = $value->name;
    	}
    	Self::censor_annual_leave($data['personal']);
        return view('user.create',$data);
    }


    public function store(Request $request)
    {	
    	
    	$data['personal'] = \Auth::user();
    	$annual_leave = $data['personal']->annual_leave;

    	$datetime_end = new \DateTime($request->input('date_timepicker_end'));
		$datetime_start = new \DateTime($request->input('date_timepicker_start'));
		$datetime_now = new \DateTime(null);
		$different = $datetime_end->diff($datetime_start);

		if($different->h >= 9){
			$different->h = 0;
			$different->d = $different->d +1 ;
		}
		
    	if($request->input('reason') == '7'){

    		if($annual_leave->sum('days') == 0 && $annual_leave->sum('hours') == 0 && $annual_leave->sum('minutes') == 0 ){
    			return redirect('/staffs/create')
    				->withInput($request->except('reason' ,'provision_way'))
					->with('errors' , '你特休已經沒了....');
    		}
    		
    		$dayoff_total = 0;
	    	$dayoff_hour = 0;
	    	if($different->m == 0){
	    		if($different->i == 30){
					$dayoff_hour = $different->h+0.5;
				}else{
					$dayoff_hour = $different->h;
				}
				$dayoff_total = ($different->d) * 8 + $dayoff_hour + $dayoff_total;
	    	}else{
	    		$dayoff_total = ($different->days) * 8;
	    	}
	    	
			$sum = ($annual_leave->sum('days')) * 8 + $annual_leave->sum('hours') + $annual_leave->sum('minutes');

			if( $sum < $dayoff_total){
				return redirect('/staffs/create')
					->withInput($request->except('reason' ,'provision_way'))
					->with('errors' , '你特休時數不夠了....');	
			}
    // 		特休請假規定(暫時性先隱藏)
    // 		$diff_datestart_datenow = $datetime_start->diff($datetime_now);
    // 		$count_datestart_datenow = Self::count_different_date_time($diff_datestart_datenow);

    // 		if( $different->d == '1' && $count_datestart_datenow->d == '0' ){
				// return redirect('/staffs/create')
				// 	->with('errors' , '請一日的特休，須在前一日申請。');
    // 		}elseif ( $different->d > '1' && $count_datestart_datenow->d < 2*$different->d ) {
    // 			return redirect('/staffs/create')
				// 	->with('errors' , '請一日以上的特休，須在請假天數的２倍天數前提前告知。');
    // 		}

    	}
    	
    	$managers = User::where('staff_id','>',$data['personal']->staff_id)->get();
    	$mail_info = "休假";
    	$this->dispatch(new SendReminderEmail($data['personal'] , $managers , $request->input('reason') , $request->input('date_timepicker_start') , $request->input('date_timepicker_end')  , $mail_info));

    	$user_dayoff = new User_dayoff;
    	$user_dayoff->user_id = $data['personal']->id;
    	$user_dayoff->staff_id = $data['personal']->staff_id;
    	$user_dayoff->date_start = $request->input('date_timepicker_start');
    	$user_dayoff->date_end = $request->input('date_timepicker_end');
    	$user_dayoff->days = $different->d;
    	$user_dayoff->hours = $different->h;
    	$user_dayoff->minutes = $different->i;
    	$user_dayoff->agent_name = $request->input('agent_name');
    	$user_dayoff->provision_id = $request->input('reason');
    	$user_dayoff->provision_way_id = $request->input('provision_way');
    	$user_dayoff->save();
      
        return redirect('/staffs/user');
        
    }

    public function staff(Request $request){

    	$user = new User;
    	$user_dayoff = new User_dayoff;
    	$data['personal'] = \Auth::user();
    	
  		if( $data['personal']->staff_id == 2 ){
  			$data['staffs'] = $user->whereIn('staff_id',[0,1,2])->get();
  		}elseif( $data['personal']->staff_id == 1 ){
    		$data['staffs'] = $user->where('staff_id',0)->get();
    	}else{
    		return redirect('/');
    	}
  		
  		

    	
    	if( $request->has('check') ){
    		
    		$personal_status = $user_dayoff->find($request->input('check'));

    		$mail_info = '休假核准';
			$this->dispatch(new SendCheckEmail($personal_status , $mail_info , $data['personal'] ));
    		

    		\DB::table('user_dayoff')
    			 ->whereIn('id',$request->input('check'))
				 ->update(['check' => '1' ]);

    	}


    	$provision = new Provision;
    	$data['provision_reason'] = $provision->provision_reason;
    	

    	return view('user.staff',$data);
    }

    public function personal(Request $request){


    	$data['personal'] = \Auth::user();
    	$data['first_day'] = $data['personal']->first_day_company;
    	$datetime_now = new \DateTime(null);
		$datetime_first_to_company = new \DateTime($data['first_day'] );

		//個人實際年資
		$data['interval'] = $datetime_now->diff($datetime_first_to_company);
		
		
		if( $datetime_first_to_company->format('Y') <= $datetime_now->format('Y')){
			$annual_leave = new Annual_leave;
			$now_year = $datetime_now->format('Y'); //2016
			$first_day_year = $datetime_first_to_company->format('Y'); //2015
			$count_loop = $now_year - $first_day_year;


			if(count($data['personal']->annual_leave()->withTrashed()->get()) - $count_loop == 1){
				
			}elseif(count($data['personal']->annual_leave()->withTrashed()->get()) - $count_loop == 0){

				// $annual_leave_days = date_create($datetime_now)->diff($datetime_first_to_company);
				$annual_leave_days = ($datetime_now)->diff($datetime_first_to_company);
				$calculate = intval($annual_leave_days->days / 365);
				$special_day = $annual_leave->gov_list[$calculate];
				\DB::table('annual_leave')->insert([
								'user_id' => $data['personal']->id,
								'days'   => (int)str_replace("日","",$special_day),
								'purchase' => $now_year.'-01-01',
								'expire_to_day' => ($now_year+1) .'-07-01',
							]);
				
			}else{
				for ($number = 0; $number <= $count_loop; $number++) { 
					$those_year = ($first_day_year + $number);
					$thos_date  = $those_year.'-12-31';

					if($first_day_year == $those_year ){
						$annual_leave_days = date_create($thos_date)->diff($datetime_first_to_company);
						$calculate = intval($annual_leave_days->days / 365);
						$calculate_remainder = $annual_leave_days->days % 365;
						$special_day = $annual_leave->gov_list[$calculate];
						\DB::table('annual_leave')->insert([
								'user_id' => $data['personal']->id,
								'days'   => (int)str_replace("日","",$special_day),
								'hours' => (int)ceil(($calculate_remainder *7*8) / 365),
								'purchase' => $datetime_first_to_company->format('Y-01-01'),
								'expire_to_day' => $datetime_first_to_company->format('Y')+1 .'-07-01',
							]);
						
					}else{
						$this_date = $those_year.'-01-01';
						$annual_leave_days = date_create($thos_date)->diff(date_create($this_date));
						$calculate = intval($annual_leave_days->days / 365);
						$calculate_remainder = $annual_leave_days->days % 365;
						$special_day = $annual_leave->gov_list[$calculate];

						\DB::table('annual_leave')->insert([
								'user_id' => $data['personal']->id,
								'days'   => (int)str_replace("日","",$special_day),
								'hours' => (int)ceil(($calculate_remainder *7*8) / 365),
								'purchase' => $those_year.'-01-01',
								'expire_to_day' => ($those_year+1) .'-07-01',
							]);
					}
				}//end of for
			}
		}
		
		$message = Self::censor_annual_leave($data['personal']);
		
		

		if($request->has('select_dayoff')){
    		$data['check_dayoff'] = $data['personal']->user_dayoff()->where('provision_id',$request->input('select_dayoff'))
								->where('check','1')->orderBy('date_start')->get();	
    	}else{
    		$data['check_dayoff'] = $data['personal']->user_dayoff()
							->where('check','1')->orderBy('date_start')->get();		
    	}
		
		$user = new User;
		// 個別休假時間總和

		$dayoff_total = $user->count_dayoff($data['check_dayoff']);

		// 假別選項
		$provision 			=  new Provision;
		$provision_way 		=  new Provision_way;
    	$data['provision'] 	=  $provision->all();
    	$data['provision_reason'] = $provision->provision_reason;

		$data['title'] = '';
		$data['leftover'] = '';
		// 計算休假剩餘時間
		if($request->has('select_dayoff')){
			
			$each_provision_sum = [];
			$each_provisions = $data['personal']->user_dayoff()->where('provision_id', $request->input('select_dayoff'))->where('check','1')->get();
			foreach ($each_provisions as $each_provision) {
				$each_provision_limit_hours = $provision_way->find($each_provision->provision_way_id);
				$each_provision_sum[$each_provision_limit_hours->id] = $each_provision_limit_hours->limit_hours;
			}
			
			$data['title'] = $data['provision_reason'][$request->input('select_dayoff')];
			
			$data['leftover'] = array_sum($each_provision_sum) - $dayoff_total;
			if($request->input('select_dayoff') == 7){
				$data['leftover'] = $user->count_dayoff($data['personal']->annual_leave)- $dayoff_total;
				$data['message'] = $message;
			}
			
		}
		
    	return view('user.personal',$data);
    }

    public function search(Request $request , $id ){
    	$data['personal'] = \Auth::user();
    	$data['url'] = '/staffs/search';
    	
    	$user = new User;
    	$user_dayoff = new User_dayoff;
    	$compensatory = new Compensatory;

    	if($id == '1'){
    		$data['staff_status'] = $user->whereIn( 'id' , $user_dayoff->where('check','1')->lists('user_id'))->get();
    		
    	}else{
    		$data['staff_status'] = $user->whereIn('id' , $compensatory->where('check','1')->lists('user_id'))->get();

    	}

    	$data['id'] = $id;

    	return view('user.search' , $data);
    }


    public function count_different_date_time($obj_date_time){
    	if($obj_date_time->h >= 9){
			$obj_date_time->h = 0;
			$obj_date_time->d = $obj_date_time->d +1 ;
		}

		return $obj_date_time;
    }

    //檢查特休
    //expire_to_day => 到期日
    public function censor_annual_leave($user){
    	$message = null;
    	$now = date('Y-m-d');
    	$now_year = date('Y');
    	foreach ($user->annual_leave as $key => $annual_leave) {
    		$expire_year = explode('-', $annual_leave->expire_to_day)[0];
    		if($now >= $annual_leave->expire_to_day){
    			$annual_leave->delete();
    		}

    		if($now_year == $expire_year){
    			if($annual_leave->days == 0){
    				$message = '您的特休中，有'.$annual_leave->hours.'小時，須於'.$annual_leave->expire_to_day.'前休完';	
    			}else{
    				$message = '您的特休中，有'.$annual_leave->days.'天，須於'.$annual_leave->expire_to_day.'前休完';	
    			}
    			
    		}
    	}
    	
		return $message;
    }

}
