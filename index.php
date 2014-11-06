<?php
include_once("settings.php");
$con=mysqli_connect($host,$username,$password,$database);
// Check connection
if (mysqli_connect_errno()) {
	$errors[] = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$tm=time();
$ref=@$_SERVER['HTTP_REFERER'];;
$agent=@$_SERVER['HTTP_USER_AGENT'];
$ip=@$_SERVER['REMOTE_ADDR'];
$tracking_page_name=@$_SERVER['REQUEST_URI'];
$strSQL = "INSERT INTO track(tm, ref, agent, ip, tracking_page_name) VALUES ('$tm','$ref','$agent','$ip','$tracking_page_name')";
$test=mysqli_query($con, $strSQL);


if(!isset($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/' ){
 	//show the google map with universities on them
 	include_once("index_maps.php");
 	exit;
}else{
	$script_url = $_REQUEST['url'];
	$id_notification_from_url_arr  	= explode('_', $script_url);
	$id_notification_from_url_arr  	= explode('_', $script_url);
	$id_notification_from_url		=	$id_notification_from_url_arr[1];
}

//print_r($id_notification_from_url_arr);

$ad_header ='<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- U1 -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-3421324621071381"
				     data-ad-slot="7852532816"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>';

$ad_sub_header	 = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Sub Header Link Ads -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:15px"
     data-ad-client="ca-pub-3421324621071381"
     data-ad-slot="9700709214"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';


$ad_content_middle = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- U - Content Middle -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-3421324621071381"
     data-ad-slot="3223856811"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';


$ad_side_bars = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- U - Vertical Bar -->
<ins class="adsbygoogle"
     style="display:inline-block;width:120px;height:240px"
     data-ad-client="ca-pub-3421324621071381"
     data-ad-slot="6037722411"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';

$ad_side_bars_right ='<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- U - SideBars -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-3421324621071381"
     data-ad-slot="1886724419"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';

$ad_other_notifications = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- U - Sub Header Second -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-3421324621071381"
     data-ad-slot="6806118410"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';


/*

Home Page with Google Map
Check box for 
List Universitites 
Types of Universities
	Central Universities
	State Universities
	Deemed Universities
	Private Universities
	
	
UI - page layout - CSS 
Google Ads accounts
Google Anaytics code 
Geo Location Counts
Latest News Information 

	
	

=====================================================================
Submit FORMS
=====================================================================
 
 	Form 1
		1. Form to select University
		2.Title of the notification
		3. Paragraphs
		4. Reference link
		5. Attache ment upload 
		6. Attachement link
	Form 2 - to upload white divs
	Form 3 - ADs data
	Form 4 - Upload Logo and Websites link
	Form 5 - Course Name + Year + Mterail - upload attachment forms
	Form 6 - Moderator Page to Approve (localhost)
=====================================================================			 
	
View Information

	All Notifications Page
	get the information for university logo link (Notification Page)
		Other latest information 
	Material Page  for SVUniversity 
	
	

=====================================================================			 
			 
Database Tables Required
 
 university 
 	id_university
 	name
 	websites
 	logo
 	type_of_university
 	address1
 	address2
 	state
 	pincode
 	city
 	established 
 	
 	
 
 notification
 	id_notification
	id_university
	title
	description
	reference_link
	attachment_link
	attachement_path
	approved
	time_created
	time_updated
	
 ads_code
 	id_position
 	code	

 hidden_divs
 	id_univeristy

  html_url
  	id_notification	
  	crawler_active

=====================================================================	

*/


//print_r($con);
//print_r($errors);
//echo '\nselect * from notification n, university u where n.id_university = u.id_university order by id_notification desc limit 1';



if($id_notification_from_url == 'HomePage'){
	// show notification as per UNIVERSITY ID
	$id_notification_from_url		=	$id_notification_from_url_arr[2];
	$qr = 'SELECT  * FROM notification n, university u
											WHERE n.id_university = u.id_university
													AND n.id_university = '.$id_notification_from_url.'
											ORDER BY id_notification DESC
											LIMIT 1';
}else{
	// show notification as per NOTIFICATION ID
	$qr = 'SELECT  * FROM notification n, university u
											WHERE n.id_university = u.id_university
													AND n.id_notification = '.$id_notification_from_url.'
											ORDER BY id_notification DESC
											LIMIT 1';
}
// echo $qr;
$r		=	mysqli_query($con, $qr);
$row 	= 	mysqli_fetch_assoc($r);
//print_r($row);
$ulogo 	= 	$row['logo'];
$uname 	= 	$row['name'];
$usites	=	$row['websites'];
$course	= 	$row['course'];
$title	= 	$row['title'];

$description1	=	$row['description1'];
$description2	=	$row['description2'];
$reference_link	=	$row['reference_link'];
$attachment_link	=	$row['attachment_link'];
$id_university	=	$row['id_university'];
/*
  
 Array ( [id_notification] => 1 
 		 [id_university] => 1 
 		 [title] => test 
 		 [description1] => test 
 		 [description2] => test 
 		 [reference_link] => test 
 		 [attachment_link] => test 
 		 [attachement_path] => 
 		 [approved] => 0 
 		 [time_created] => 1410895765 
 		 [time_updated] => 1410895765 
 		 [name] => Osmania University 
 		 [websites] => http://www.osmania.ac.in/ 
 		 [logo] => 1.jpg 
 		 [type_of_university] => C 
 		 [address1] => Administrative Building 
 		 [address2] => Osmania University Campus 
 		 [state] => Telangana 
 		 [pincode] => 500007 
 		 [city] => Hyderabad 
 		 [established] => 1918 
 		) 
*/

// 	$r		=	mysqli_query($con, 'select * from notification n, university u where n.id_university = u.id_university order by id_notification desc limit 1, 10');


$other_notifications	=	" No Other notifications available from this University ";

$on_query = 			"SELECT seo_filename, title, course 
						FROM notification  
						WHERE id_notification NOT IN  ($id_notification_from_url) AND id_university = $id_university 
								 order by id_notification desc
						LIMIT 0, 20";


$r		=	mysqli_query($con, $on_query);
if($r){
	if(mysqli_num_rows($r)){
		$other_notifications = '';
		while($row 	= 	mysqli_fetch_assoc($r)){
			$other_notifications	.=	"<br>[".$row['course']."]<a href='".curPageURL()."/".$row['seo_filename']."'>".$row['title']."</a>";
		}
	}
}

function curPageURL() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"];
	}
	return $pageURL;
}

?><!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="blended_layout.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<title><?php echo $uname;?> :: Notifications :: Admissions :: Results :: Contact Details :: Courses </title>
<meta name="description" content="<?php echo $uname;?> :: Notifications :: Admissions :: Results :: Contact Details :: Courses.">
<meta name="keywords" content="<?php echo $uname;?> Notifications, <?php echo $uname;?> Admissions, <?php echo $uname;?> Results, <?php echo $uname;?> Contact Details, <?php echo $uname;?> Courses, <?php echo $uname;?> Address.">
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<div class="blended_grid">

	<div class="pageHeader">
		<div style="float: left;">
			<img src="logo3.png">
		</div>
		<div style="float: right;">
			<?php echo $ad_header; ?>
		</div>
	</div>
	
	<div class="pageHeaderSub">
		<a href="/"><img src='university_results_fee_exams_notifications_courses.gif'></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ad_sub_header; ?>
	</div>



	<div class="pageContent">
	<center>
		(<u style="background-color:yellow" >NOTIFICATION DETAILS</u>)
	<br>
		<img src="/ulogos/<?php echo $ulogo;?>" alt="<?php echo $uname;?> Logo">
		<h1><?php echo $uname;?></h1>
		<h4><a href="<?php echo $usites;?>"  alt="<?php echo $uname;?>" target="_new"><?php echo $usites;?></a></h4>
	</center>
	
	<table border="1" width="100%" style="border:1 none">
		<tr><td width="20%">Course</td>			<td><?php echo $course; ?></td>	</tr>
		<tr><td>Title</td>			<td><?php echo $title; ?></td>	</tr>
		<tr><td colspan="2">Description<br>	<center><?php echo $ad_other_notifications; ?></center><br><?php echo $description1; ?><br><br><center><?php echo $ad_content_middle; ?></center><br><br><?php echo $description2; ?></td>	</tr>
		<tr><td>University Link</td><td><a href='<?php echo $reference_link; ?>'>Link</a></td>	</tr>
		<tr><td colspan="2"><center><a href='<?php echo $attachment_link; ?>'>Download Full Notification</a></center></tr>	
	</table>
	 
	</div>


	
	<div class="pageFooter">
		<h3>Other Notifications :</h3> 
		<?php echo $other_notifications; ?>
		<br>
		<center><?php echo $ad_other_notifications; ?></center>
	</div>
	<div class="pageFooterSub">
		Study Materials<br>
		<center><a href="http://checkpagerank.net/" title="PageRank Checker" target="_blank"><img src="http://checkpagerank.net/pricon.php?key=a3f8ea4781f351a7d625165fdcb17aff&t=0" width="70" height="20" alt="Check PageRank" /></a></center>
	</div>

	
	</div>
<!--------------------- GOOGLE TRACKING CODE ------------------>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-55069428-1', 'auto');
  ga('send', 'pageview');
</script>

<script type="text/javascript">
var infolinks_pid = 2207260;
var infolinks_wsid = 0;
</script>


<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
<!--------------------- GOOGLE TRACKING CODE ------------------>
</body>
</html>








