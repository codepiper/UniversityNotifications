<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker animations with <code>setTimeout()</code></title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
// If you're adding a number of markers, you may want to
// drop them on the map consecutively rather than all at once.
// This example shows how to use setTimeout() to space
// your markers' animation.

var india = new google.maps.LatLng(21.7679, 78.8718);

var neighborhoods = [
  new google.maps.LatLng(21.7679, 78.8718),
  new google.maps.LatLng(22.7679, 78.8718),
  new google.maps.LatLng(23.7679, 78.8718),
  new google.maps.LatLng(24.7679, 78.8718)
];

var markers = [];
var iterator = 0;
var map;
var infowindow = null;

function initialize() {
	var mapOptions = {
					    zoom: 5,
					    center: india
					  };

  	var contentString = 'testing content';

	infowindow = new google.maps.InfoWindow({
					  content: contentString,
					  maxWidth: 200
					});
  
  	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function showUniversities() {
  for (var i = 0; i < neighborhoods.length; i++) {
    setTimeout(function() {
      addMarker();
    }, i * 200);
  }
}

function addMarker() {
	var datatoshow = ["a", "b", "c", "d"]; 
	alert('data to insert '+datatoshow[iterator]);
	
	marker	= new google.maps.Marker({
	    position: neighborhoods[iterator],
	    map: map,
	    draggable: false,
	    animation: google.maps.Animation.DROP,
	    htmldd: datatoshow[iterator]
	  });

  	markers.push(marker);

  	google.maps.event.addListener(marker, 'click', function () {
		// where I have added .html to the marker object.
		alert('data to show '+this.htmldd);
		infowindow.setContent(this.htmldd);
		infowindow.open(map, this);
	});
	 
  iterator++;
}

function showCompany(lat, lng) {
	// Take to State Center and Show the Icons
    var position = new google.maps.LatLng(lat, lng);
    map.setCenter(position);
    alert(lat, lng);
}

google.maps.event.addDomListener(window, 'load', initialize);


    </script>
  </head>
  <body>
    <div id="panel" style="margin-left: -52px">
    	Country 
    	<select>
    	<option>India </option>
    	</select>
        State 
        <select>
    	<option>All</option>
        <option value=''>Andhra Pradesh</option>
        </select>
          <button id="drop" onclick="showUniversities()">Show Universities</button>
     </div>
    <div id="map-canvas"></div>
  </body>
</html>

