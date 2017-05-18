<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Compensatory;
use App\User_dayoff;
use App\Provision;
use Illuminate\Contracts\Mail\Mailer;

class SendCheckEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $staffs;
    protected $mail_info;
    protected $manager;

    public function __construct( $staffs , $mail_info , $manager  )
    {
        $this->staffs          = $staffs;
        $this->mail_info       = $mail_info;
        $this->manager 		   = $manager;

    }
    

    public function handle(Mailer $mailer)
    {
    	$mail_info = $this->mail_info;
    	$user = new User;

    	foreach ($this->staffs as $staff) {
    		$staff_info = $staff->user;

    		if($mail_info == '休假核准'){
    			$provision = new Provision;
        		$provision_reason = $provision->provision_reason[$staff->provision_id];
    			$mailer->send('emails.check_mail' ,['personal_info' => $staff_info , 'mail_info' => $mail_info  , 'manager' => $this->manager , 'text' => $mail_info.'時間： '.$staff->date_start. '至' .$staff->date_end ] ,function($m) use ($staff_info ,$mail_info){
					$m->from('jason@capsulecorporation.cc', '瓜瓜');
					$m->to($staff_info->email)->subject($staff_info->name .'的'.$mail_info .'訊息');
				});

    		}else{
    			$mailer->send('emails.check_mail' ,['personal_info' => $staff_info , 'mail_info' => $mail_info  , 'manager' => $this->manager , 'text' => $mail_info.'時間： '.$staff->date. ' ' .$staff->time_start. '至' .$staff->time_end ] ,function($m) use ($staff_info ,$mail_info){
					$m->from('jason@capsulecorporation.cc', '瓜瓜');
					$m->to($staff_info->email)->subject($staff_info->name .'的'.$mail_info .'訊息');
				});
    		}

    	}
		
    }
}
