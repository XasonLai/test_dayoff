<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link rel="stylesheet" href=""> 
 
 <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCRFqcFXc2EZ3-XA1KIolCamLKl5xOSSLk" async="" defer="defer" type="text/javascript"></script>

 
 <title>Google Maps</title>
 </head>
 <body>
 <button onclick="getPosition()">getadd</button>
 <div id="message"></div>
   <p>
	<div id="googlemap" style="width:500px;height:600px;"></div>
   </p>
 </body>
 <script type="text/javascript">
function getPosition(){
	var geo=window.navigator.geolocation;
	geo.getCurrentPosition(succCallback);

}
function succCallback(a){
	var lati=a.coords.latitude;
	var longi=a.coords.longitude;
//var latlng=new google.maps.LatLng(25.034439,121.564064);
 document.getElementById('message').innerHTML='緯度{Latitude}:'+lati+'<Br/>  經度{Longitude}:'+longi;
//var latlng=new google.maps.LatLng(lati,longi);
var xy=new google.maps.LatLng(lati,longi);
var area=document.getElementById("googlemap");
var option={
	zoom:14,
	center:xy,
	mapTypeId:google.maps.MapTypeId.ROADMAP};
var display=new google.maps.Map(area,option);
var marker=new google.maps.Marker({position:xy,map:display});
}


 </script>
</html>