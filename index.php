<?php
include('settings.php');


if(isset($_ENV['SCRIPT_URL'])){
$script_url = $_ENV['SCRIPT_URL'];
$id_notification_from_url_arr  	= explode('_', $script_url);
$id_notification_from_url		=	$id_notification_from_url_arr[1];
}else{
	//show the google map with universities on them
	include_once("index_maps.php");
	
}


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

$con=mysqli_connect($host,$username,$password,$database);
// Check connection
if (mysqli_connect_errno()) {
	$errors[] = "Failed to connect to MySQL: " . mysqli_connect_error();
}
//print_r($con);
//echo '\nselect * from notification n, university u where n.id_university = u.id_university order by id_notification desc limit 1';



$r		=	mysqli_query($con, 'SELECT  * FROM notification n, university u 
											WHERE n.id_university = u.id_university 
													AND n.id_notification = '.$id_notification_from_url.' 
											ORDER BY id_notification DESC 
											LIMIT 1');
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
$on_query = "select seo_filename, title, course from notification WHERE id_notification NOT IN (1) order by id_notification LIMIT 0, 20";
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

?>
<?xml version="1.0" encoding="iso-8859-1"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Website for All University Notifications </title>
<meta name="title" content="University Notification" />
<meta name="author" content="Administrator" />
<meta name="description" content="Osmania Unversity Notification, Aligarh Univerisy Notification, Unviversity of Calicut Notification, Bangalore University Notification, Delhi University Notification " />
<meta name="keywords" content="calicut university,universities in Andhra, Universities in Karnata, Universities in Kerala, Universities in Tamilnadu, College Notification, Manipal University Notification, Indira Gandhi Open Univesity Notificaiton" />
<meta name="Generator" content="- Copyright (C) 2012 - 2014 Open Source Matters. All rights reserved." />
<meta name="robots" content="index, follow" />
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
		<center><?php echo $ad_sub_header; ?></center>
	</div>



	<div class="pageContent">
	<center>
		(<u style="background-color:yellow" >NOTIFICATION DETAILS</u>)
	<br>
	<br>
		<img src="/ulogos/<?php echo $ulogo;?>" alt="University Logo">
		<h1><?php echo $uname;?></h1>
		<h4><a href="<?php echo $usites;?>"  alt="<?php echo $uname;?>" target="_new"><?php echo $usites;?></a></h4>
	</center>
	
	
	<table border="1" width="100%" style="border:1 none">
		<tr><td width="20%">Course</td>			<td><?php echo $course; ?></td>	</tr>
		<tr><td>Title</td>			<td><?php echo $title; ?></td>	</tr>
		<tr><td colspan="2">Description<br><?php echo $description1; ?><br><br><center><?php echo $ad_content_middle; ?></center><br><br><?php echo $description2; ?></td>	</tr>
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
		Study Materials
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








