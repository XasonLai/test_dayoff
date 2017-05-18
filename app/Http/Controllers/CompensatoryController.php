<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use App\User;
use App\Compensatory;
use App\Jobs\SendReminderEmail;
use App\Jobs\SendCheckEmail;

class CompensatoryController extends Controller
{
    
    public function index()
    {
    	$user = new User;
    	$data['personal'] = \Auth::user();
    	
  		if( $data['personal']->staff_id == 2 ){
  			$data['staffs'] = $user->whereIn('staff_id',[0,1,2])->get();
  		}elseif( $data['personal']->staff_id == 1 ){
    		$data['staffs'] = $user->where('staff_id',0)->get();
    	}else{
    		return redirect('/');
    	}

    	return view( 'user.compensatory_check',$data );
    }

    public function create(){
    	$data['personal'] = \Auth::user();
    	
        return view('user.compensatory',$data);
    }

    public function store(Request $request)
    {
        
        $user = \Auth::user();
        $compensatory_date = $request->input('compensatory_date');
        $start_time = new \DateTime($request->input('time_start'));
        $end_time 	= new \DateTime($request->input('time_end'));
		$surplus_time = $end_time->diff($start_time);
		
		$timestamp = strtotime($compensatory_date);
		
		if( date('D', $timestamp) !== "Sun" && date('D', $timestamp) !== "Sat" ){
			if( strtotime($request->input('time_start')) < strtotime("20:30:00") ){
				return redirect('/staffs/compensatory')
					->with('errors' , '平日加班須在20:30後，別惡搞我。');
			}
		}
		
		$user_compensatory = $user->compensatory;
		$repeat_date = $user_compensatory->contains('date',$compensatory_date);
		
		if($repeat_date){
			return redirect('/staffs/compensatory')
					->withInput()
					->with('errors' , '之前有輸入相同的日期'.$compensatory_date);
		}
		

		\DB::table('compensatory')->insert(
        		['user_id' 		=> $user->id, 
        		 'time_start' 	=> $request->input('time_start'),
        		 'time_end'  	=> $request->input('time_end'),
        		 'date' 		=> $compensatory_date,
        		 'hours'			=> $surplus_time->h,
        		 'minutes'		=> $surplus_time->i,
        		]
        );
		$managers = User::where('staff_id','>',$user->staff_id)->get();
		$mail_info = "加班";
		$this->dispatch(new SendReminderEmail($user , $managers ,  $compensatory_date , $request->input('time_start') , $request->input('time_end') , $mail_info));

		return redirect('/staffs/user');
    }

    public function update(Request $request ,$id)
    {
        $user = new User;
    	$data['personal'] = \Auth::user();

    	dd($request);
    	$compensatory = new Compensatory;
    	
  		if( $data['personal']->staff_id == 2 ){
  			$data['staffs'] = $user->whereIn('staff_id',[0,1,2])->get();
  		}elseif( $data['personal']->staff_id == 1 ){
    		$data['staffs'] = $user->where('staff_id',0)->get();
    	}else{
    		return redirect('/');
    	}

    	if( $request->has('check') ){

    		$personal_compensatory_status = $compensatory->find($request->input('check'));
    		
    		$mail_info = '加班核准';
			$this->dispatch(new SendCheckEmail($personal_compensatory_status , $mail_info , $data['personal'] ));

    		\DB::table('compensatory')
    			 ->whereIn('id',$request->input('check'))
				 ->update(['check' => '1' ]);
    	}
    	

        return view( 'user.compensatory_check',$data );
    }

   
}
