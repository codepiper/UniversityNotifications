<?php 
	include_once('settings.php');
	$con			=	mysqli_connect($host,$username,$password,$database);
	
	/*********** STATES INFORMATION - lat and long ****************************/
	$states_array 	= 	array();
	$states_ids_array	=	array();
	$query			= 	"SELECT id_state, name, latitude, longitude FROM states where id_country = 81";
	$r				=	mysqli_query($con, $query);
	
	if(mysqli_num_rows($r)){
		while($row = mysqli_fetch_assoc($r)){
			array_push($states_ids_array, $row['id_state']);
			$states_array[$row['id_state']] = array("name"=>$row['name'], "latitude"=>$row['latitude'], "longitude"=>$row['longitude'] );
		}
	}
	$states_json = json_encode($states_array);
	/*********** STATES INFORMATION - lat and long ****************************/
	
	
	
		
	/*********** UNIVERSITY INFORMATION - lat and long ****************************/
	$universities_array 	= 	array();
	
	$uquery			= 	"SELECT id_university, u.name, u.state, u.address1, u.address2, 
									u.type_of_university, u.pincode, u.latitude, u.longitude,
									u.websites, u.logo
							FROM university u, states s, countries c
							WHERE u.state IN (".implode(',', $states_ids_array).")  
								AND u.state = s.id_state 
								AND s.id_country = c.id_country 
								AND c.id_country = 81";
	//echo "<br><br><br>".$uquery;
	
	$ur				=	mysqli_query($con, $uquery);
	
	if(mysqli_num_rows($ur)){
		while($row = mysqli_fetch_assoc($ur)){
			
			//print_r($row);

			if(empty($universities_array[$row['state']])){
				$universities_array[$row['state']] = array();
			}
			//print_r($universities_array);
			
			array_push($universities_array[$row['state']], array(
																	"name"      => $row['name'], 
																	"latitude"  => $row['latitude'], 
																	"longitude" => $row['longitude'],
																	"website"   => $row['websites'],
																	"address1"  => $row['address1'],
																	"address2"  => $row['address2'],
																	"pincode"  => $row['pincode'],
																	"type_of_university" => $row['type_of_university'],
																	"logo"		=>	empty($row['logo']) ? $row['id_university'].'.jpg': $row['logo'], 
																	"id_university"		=>	$row['id_university'],
																));
		}
	}
	$universities_json = json_encode($universities_array);
	//echo "<pre>";
	//print_r($universities_array);
	
	/*********** UNIVERSITY INFORMATION - lat and long ****************************/
	
	
	
	
?>
<!DOCTYPE html>
<html>
  <head>
  
    <meta charset="utf-8"/>
    <meta property="og:title" content="Latest Updates from Universities around the world"/>
    <meta name="title" content="Notification" />
	<meta name="author" content="Administrator" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">	
	<meta property="og:type" content="article"/>
	<meta property="og:description" content="Osmania University Notifications, S V University Notification, Delhi University Notification, IISc Notification, IIT Notification, IIM Notifications"/>
	<meta property="og:url" content="http://universitynotification.in/"/>
	<meta property="og:site_name" content="University Notification"/>
	<title>Latest Notifications &amp; News from Universities around the world.</title>
	<meta name="description" content="All Indian Universities, University of Calicut, Osmania University, IISc Notifications, IIScResults, IIM Syllabus Books, University Results, University Recounting, Aligarh University, Mumbai University, Delhi University, Manipal University, Airforce Medical College Pune...."/>
	<meta name="keywords" content="univerity notification, calicut university,universities in kerala, malabar, University Results,University Exams,University Website,Univerisyt,VTU Results,VTU Syllabus,jntuk,jntuh,jntua,jntu kakinada,jntu hyderabad,jntu anantapur,jntu notifications,jntu results,jntu kakinada notifications,jntu anantapur notifications,jntu anantapur results,jntu kakinada results,jntu hyderabad notifications,jntu hyderabad results"/>
	<link rel="canonical" href="http://universitynotification.in/" />
	<meta property="og:locale" content="en_US" />
	<meta name="robots" content="index, follow" />
	<meta name="Generator" content="- Copyright (C) 2012 - 2014 Open Source Matters. All rights reserved." />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="http://universitynotification.in/logo3.png" />
	<meta name="msvalidate.01" content="45D144059CC899BF7E5D6C98DEEF3A5B" />
	<meta name="google-site-verification" content="DmaAY7wisy_ez9uKR-3hLB8VRUhAdI3B2GR1jhzBudQ" />
	<meta name="alexaVerifyID" content="opfeHeooTmAMlitK8w3hoT-sBng"/>
	<script type="application/ld+json">{ "@context": "http://schema.org", "@type": "WebSite", "url": "http://universitynotification.in/", "potentialAction": { "@type": "SearchAction", "target": "http://universitynotification.in/?s={search_term}", "query-input": "required name=search_term" } }</script>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
    <script>
// If you're adding a number of markers, you may want to
// drop them on the map consecutively rather than all at once.
// This example shows how to use setTimeout() to space
// your markers' animation.

var countries_lat_long 		= new Array();
var States_lat_long 		= new Array();
var universities_lat_long	= new Array();
var india_lat_long 			= new google.maps.LatLng(21.7679, 78.8718);
var markers 				= [];
var iterator 				= 0;
var map;
var infowindow 				= null;
var states_json 			= <?php echo $states_json; ?>;
var universities_json 		= <?php echo $universities_json; ?>;

var neighborhoods = [];

function initialize() {
	var mapOptions = {zoom: 5,center: india_lat_long};
  	var contentString = 'testing content';
	infowindow = new google.maps.InfoWindow({content: contentString,maxWidth: 400});
  	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}


function addMarker(datatoshow) {
	marker	= new google.maps.Marker({
	    position: new google.maps.LatLng(datatoshow.latitude, datatoshow.longitude),
	    map: map,
	    draggable: false,
	    animation: google.maps.Animation.DROP,
	    htmldd: datatoshow['name']
	  });

  	markers.push(marker);
  	
  	google.maps.event.addListener(marker, 'click', function () {
  	  	if(datatoshow['type_of_university'] == 'S'){
  	  		datatoshow['type_of_university'] = 'State Level'
  	  	}else{
  	  		datatoshow['type_of_university'] = 'Central Level'
  	  	}
  	  	
  	  	contentToShow = "<center><img src=\"/ulogos/"+datatoshow['logo']+"\"></center><br>"+datatoshow['name']+'<br> Type of University : '+datatoshow['type_of_university']+"<a href=\""+sanitizeStr(datatoshow['name'])+"_HomePage_"+datatoshow['id_university']+"\"><br><center>Notifications >></center></a>";
		//infowindow.setTitle(this.htmldd);
		infowindow.setContent(contentToShow);
		//infowindow.maxWidth(200);
		infowindow.open(map, this);
	});
  iterator++;
}

function sanitizeStr(strToSanitize){
	var res = strToSanitize.replace(/ /g,"-");
	return res;
}


function showUniversities() {

 	// get country, state, univeristy ID
 	var id_country 		= $('#country').val();
 	var id_state 		= $('#state').val(); 	
 	var id_university 	= $('#university').val();

	if(id_university == 0){
	}else{
	}

	ujson		=	<?php echo $universities_json; ?>;
	var neighborhoods	=	ujson[id_state];
	console.log(neighborhoods);
	  for (var i = 0; i < neighborhoods.length; i++) {
      addMarker(neighborhoods[i]);
  }
}


// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
	  setAllMap(null);
}


//Sets the map on all markers in the array.
function setAllMap(map) {
	console.log('ALL MARKERS :'+markers[0]);
	console.log('ALL MARKERS :'+markers.length);
	for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}


function showState(lat, lng) {
	// Take to State Center and Show the Icons
    var position = new google.maps.LatLng(lat, lng);
    map.setCenter(position);
    map.setZoom(8);    
	//clearMarkers();
    var styles = [
                  {
                    stylers: [
                      { hue: "#00ffe6" },
                      { saturation: -20 }
                    ]
                  },{
                    featureType: "poi.government",
                    elementType: "geometry",
                    stylers: [
                      { lightness: 100 },
                      { visibility: "simplified" }
                    ]
                  }
                ];
                map.setOptions({styles: styles});
            	for (var i = 0; i < markers.length; i++) {
            	    markers[i].setMap(null);
            	}
                markers = [];
                var state_level_verisities = universities_json[$("#state").val()];
                if(state_level_verisities == undefined){
                	alert('No universiteis to show');
                }else{
                	showUniversities();
                }
}
google.maps.event.addDomListener(window, 'load', initialize);



$( document ).ready(function() {

	// COUNTRY LEVEL
	$("#country").change(function(){
		console.log(' i touched country');
		$('#state').find('option').remove().end().append("<option value='0'>Select State</option>");
		$("#state").val(0);		
		//$('#university').find('option').remove().end().append("<option value='0'>All</option>");
		$('#university').find('option').remove();
		$("#university").val(0);		
	});

	

	// STATE LEVEL	
	$("#state").change(function(){
		console.log(' i touched state');
		if($("#state").val() != 0){ 
			$('#university').find('option').remove().end().append("<option value='0'>ALL</option>");
		}
		var state_selected  = $("#state").val();
		var universities_list_4_state = universities_json[state_selected];
		var state_info		=	states_json[state_selected];
		showState(state_info.latitude, state_info.longitude);
	});


	
	// UNIVERSITY LEVEL	
	$("#university").change(function(){
		console.log(' i touched university');
	});

	// Default values
	$("#country").val(81);
	$("#state").val(0);	
	$('#university').find('option').remove();
});
</script>
    
<?php 

	$select_country 		=	get_select_options_data('countries', 'country', 'india');
	$select_state 			=	get_select_options_data('states', 'state');
	$select_university 		=	get_select_options_data('university', 'university' );
	
	function get_select_options_data($table_name, $select_name, $selected_value = null){
		global $con;
		$r	=	mysqli_query($con, 'select  * from '.$table_name);
		
		$selbox = '<select name='.$select_name.' id='.$select_name.' >';
		if($select_name == 'state'){
			$selbox	.= '<option value=\'0\'>Select State</option>';
		}
		if($select_name == 'university'){
			$selbox	.= '<option value=\'0\'>All</option>';
		}
		
		while($row = mysqli_fetch_assoc($r)){
			if(strtolower($row['name']) == strtolower($selected_value)){
				//echo "<br> MATCHED".strtolower($row['name']).$selected_value.'--';
				$selbox	.= '<option value=\''.$row["id_$select_name"].'\' selected="selected">'.$row["name"].'</option>';
			}else{
				$selbox	.= '<option value=\''.$row["id_$select_name"].'\'>'.$row["name"].'</option>';
			}
	
		}
		$selbox	.= '</select>';
		return $selbox;
	}
		

?>
    
  </head>
  <body>
    <div id="panel" style="margin-left: -52px">
    	Country <?php echo $select_country; ?>
    	State <?php echo $select_state; ?>
    	Unveristity <?php echo $select_university; ?>
          <button id="drop" onclick="showUniversities()">Show</button>
     </div>
    <div id="map-canvas"></div>
  </body>
</html>

