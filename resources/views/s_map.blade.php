<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        width:  650px;
		height: 450px;
      }
#right-panel {
  font-family: 'Roboto','sans-serif';
  line-height: 30px;
  padding-left: 10px;
}

#right-panel select, #right-panel input {
  font-size: 15px;
}

#right-panel select {
  width: 100%;
}

#right-panel i {
  font-size: 12px;
}


#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}


    </style>
    <title>Place search pagination</title>
    <script>
var map;
var myLatLng = {lat : 25.04216, lng : 121.50758};
var infowindow ;


function initMap() {
  var pyrmont = myLatLng;

  map = new google.maps.Map(document.getElementById('map'), {
    center: pyrmont,
    zoom: 15
  });
  infowindow = new google.maps.InfoWindow();

  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch({
    location: pyrmont,
    radius: 700,
    types: ['food']
  }, processResults);
}

function processResults(results, status, pagination) {
  if (status !== google.maps.places.PlacesServiceStatus.OK) {
    return;
  } else {
  	for(var i = 0 ; i < results.length; i++){
  		createMarkers(results[i]);	
  	}
    // createMarkers(results);

    if (pagination.hasNextPage) {
      var moreButton = document.getElementById('more');

      moreButton.disabled = false;

      moreButton.addEventListener('click', function() {
        moreButton.disabled = true;
        pagination.nextPage();
      });
    }
  }
}

function createMarkers(places) {
  var bounds = new google.maps.LatLngBounds();
  var placesList = document.getElementById('places');

  // for (var i = 0, place; place = places[i]; i++) {
    // var image = {
    //   url: place.icon,
    //   size: new google.maps.Size(71, 71),
    //   origin: new google.maps.Point(0, 0),
    //   anchor: new google.maps.Point(17, 34),
    //   scaledSize: new google.maps.Size(25, 25)
    // };

    var marker = new google.maps.Marker({
      map: map,
      // icon: image,
      title: places.name,
      position: places.geometry.location
    });


    // placesList.innerHTML += '<input type="text" id="title" name="place['+ i +'][title]" value="' + place.name  + '">' + '<input type="text" id="place_id" name="place['+ i +'][place_id]" value=' + place.place_id  + '>' + '<input type="text" name="place['+ i +'][lat]" id="lat" value=' + marker.getPosition().lat()+ '>' + '<input type="text"  id="lng" name="place['+ i +'][lng]" value=' + marker.getPosition().lng()+ '>' + '<br>';
    google.maps.event.addListener(marker , 'click' , function(){
    	infowindow.setContent(places.name);
    	infowindow.open(map, this);
    });
    bounds.extend(places.geometry.location);
  // }
  // map.fitBounds(bounds);
}
	
	

    </script>
    
  </head>
  <body>
    <div id="map"></div>
    <div id="right-panel">
      <h2>Results</h2>
 	<input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <form action='/map/add' method="post">
      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
      <div id='places'>
	  </div>
      <button class="btn btn-sm btn-danger">Save</button>
	</form>
      <!-- <button id="more">More results</button> -->
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRFqcFXc2EZ3-XA1KIolCamLKl5xOSSLk&signed_in=true&libraries=places&callback=initMap" async defer></script>
  </body>
</html>