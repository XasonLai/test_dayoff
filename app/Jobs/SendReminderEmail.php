<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Provision;
use Illuminate\Contracts\Mail\Mailer;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $managers;
    protected $date_start;
    protected $date_end;
    protected $status;
    protected $mail_info;

    public function __construct( $user , $managers , $status , $date_start , $date_end  , $mail_info)
    {
    	
    	$this->user 	  = $user;
    	$this->managers   = $managers;
    	$this->date_start = $date_start;
    	$this->date_end   = $date_end;
    	$this->status     = $status;
    	$this->mail_info  = $mail_info;
    }

    
    public function handle(Mailer $mailer)
    {
        $user = $this->user;
        $managers = $this->managers;
        $mail_info = $this->mail_info;
        if($mail_info === '休假'){
        	$provision = new Provision;
        	$provision_reason = $provision->provision_reason[$this->status];
        	$mail_status = 	'，原因：'.$provision_reason;
        }else{
        	$mail_status = '，日期：'.$this->status;
        }
        
        $mailer->send(['html' => 'emails.123'], ['user' => $user , 'mail_info' => $mail_info , 'text' => $mail_info.':'.$this->date_start .'至' . $this->date_end . $mail_status ] , function ($m) use( $user , $managers , $mail_info ) {
            foreach ($managers as $manager) {
				$m->from('jason@capsulecorporation.cc', '瓜瓜');

				$m->to('fox@capsulecorporation.cc')->subject($user->name .'的'. $mail_info.'訊息');
			}
        });

        
    }
}
