@extends('welcome')

@section('welcome_css')
<style type="text/css">
body{background-color:#fff;text-align:center;}
#Result{border:3px solid #40AA53;margin:0 auto;text-align:center;height:400px;width:660px;padding:150px 0;background:#efe;}
#ResultNum{font-size:30pt;font-family:Verdana}
#Button{margin:50px 0 0 0;}
#Button input{font-size:40px;padding:0 50px;}
#btn{background-color:#40AA53;border:1px solid #40AA53;width:20%;height:45px;margin:0em auto;font-size:1em;border-radius:2.5px;-moz-border-radius:2.5px;-webkit-border-radius:2.5px;color:#FFF;}

#map{border:3px solid #40AA53;margin:0 auto;text-align:center;height:400px;width:660px;padding:150px 0;background:#efe;}
</style>
@endsection
@section('content')
<div class="container">
	<h1 style="color:#40AA53">抽奖结果</h1>

	<div id="Result" style="color:#40AA53">
	<span id="ResultNum"></span>
	</div>
	<div id="map" style="display:none"></div>

	<div id="Button">
	<input type='button' id="btn" value='开始' onclick='beginRndNum(this)'/>
	</div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRFqcFXc2EZ3-XA1KIolCamLKl5xOSSLk&signed_in=true&callback=initMap" async defer></script>

</div>

<script type="text/javascript">
	var g_Interval = 1;
	var g_PersonCount = {!!count($map)!!};
	var map_name = {!!$map!!};
	var g_Timer;
	var running = false;
	var infowindow;
	
	function beginRndNum(trigger){
		if(running){
			running = false;
			clearTimeout(g_Timer);		
			$(trigger).val("开始");
			$('#ResultNum').css('color','red');
		}
		else{
			running = true;
			$('#ResultNum').css('color','black');
			$(trigger).val("停止");
			beginTimer();
		}
	}

	function updateRndNum(){
		var num = Math.floor(Math.random()*g_PersonCount);
		var name = map_name[num].title;
		var lat  = map_name[num].lat;
		var lng  = map_name[num].lng;
		$('#ResultNum').html(name);
		initMap(lat , lng);
	}

	function beginTimer(){
		g_Timer = setTimeout(beat, g_Interval);
		$('#map').css('display','block');
	}

	function beat() {
		g_Timer = setTimeout(beat, g_Interval);
		updateRndNum();
	}

	function initMap(lat , lng) {
	  var myLatLng = {lat, lng};

	  var map = new google.maps.Map(document.getElementById('map'), {
	    zoom: 17,
	    center: myLatLng
	  });

	  var marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map,
	    title: 'Hello World!'
	  });
	  console.log(map);
	  infowindow.setContent(map.name);
      infowindow.open(map, this);
	}


</script>

@endsection

@section('welcome_js')
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('js/ckeditor/config.js')}}"></script>


@endsection
