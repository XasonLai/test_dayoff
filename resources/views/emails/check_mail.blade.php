<div style="color:#333;">
  
  <p>收到來自：{{$mail_info}}確認的來信</p> 

  <hr>
  <p>
  	內容：<br> {{$personal_info->name}}的休假時間： {!!nl2br($text)!!}<br>

  	{{$manager->name}} ( {{$manager->english_name}} )  已核准您的{{$mail_info}}，請安心{{$mail_info}}。
  </p>
  <hr/>
  <hr>

</div>