<!--  AIzaSyBNvnFrUFRAK-02Inp90P2JqnS1mmo4gfk -->
<!DOCTYPE html>
<html>
  <head>
    <style>
      #map_canvas {
        /*width: 500px;
        height: 400px;*/
      }
      .Absolute-Center {
		  width: 60%;
		  height: 95%;
		  overflow: auto;
		  margin: auto;
		  position: absolute;
		  top: 0; left: 0; bottom: 0; right: 0;
		}
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize() {
		var myLatlng = new google.maps.LatLng(21.7679, 78.8718);
        var mapCanvas = document.getElementById('map_canvas');
        var mapOptions = {
          center: myLatlng,
          zoom: 5,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!'
        });
              
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(41.7679, 78.8718);,
            map: map,
            title: 'Hello World!'
        });

                
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map_canvas" class="Absolute-Center"></div>
  </body>
</html>