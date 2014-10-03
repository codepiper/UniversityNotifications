<?php 
echo "test";
?>
<scritp>
var myLatlng = new google.maps.LatLng(37.775, -122.4183333);

var myOptions =
{
    zoom: 2,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
}
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

var address = "Belarus";
var geocoder = new google.maps.Geocoder();
geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        map.fitBounds(results[0].geometry.bounds);
    } else {
        alert("Geocode was not successful for the following reason: " + status);
    }
});
</scritp>
