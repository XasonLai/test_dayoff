<!DOCTYPE html> 
<html> 
<title>W3.CSS</title> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css"> 
 
<style> 
.ps { 
 overflow: hidden; 
 animation-name: example; 
 animation-timing-function: linear; 
 animation-duration: 2s; 
 animation-fill-mode: both; 
 
} 
 
 
@keyframes example { 
 0% {opacity:1 } 
 100% { 
 opacity:0 ; 
 overflow:hidden; 
 
 } 
} 
 
 
</style> 
 
<body> 
 
<div class="w3-content" style="max-width:500px"> 
<h2>Animate Fading</h2> 
<p>The w3-animate-fading class fades in and out elements every 10 seconds (continuously).</p> 
 
<img class="mySlides ps" id="img_ps" src="http://i.imgur.com/yPxLc3v.jpg" style="width:100%"> 
<img class="mySlides ps" id="img_ps" src="http://i.imgur.com/yPxLc3v.jpg" style="width:100%"> 
 
<p id='ppp'>aaaaaaa</p> 
</div> 
 
</body> 
 
 
<script> 
 
window.onload = function(){ 
 var classname = document.getElementsByClassName("ps"); 
 var num = classname.length; 
 
 for (var i = 0; i < num ; i++) { 
 
 	(function(id){ 
  id.addEventListener('animationend', function(){ 
   id.style.display='none';}, 
   false); 
 	})(classname[i]) 
 } 
} 
 
 
</script> 
</html>