<?php
include('settings.php');
/*
 UserCake Version: 2.0.2
http://usercake.com
*/

//require_once("models/config.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
//if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
echo "<pre>";
//print_r($_REQUEST);


			$con=mysqli_connect($host,$username,$password,$database);
			// Check connection
			if (mysqli_connect_errno()) {
				$errors[] = "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			
		if(isset($_POST['form_subission']) && $_POST['form_subission'] == 1){	
			if(!empty($_FILES['file'])){		
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["file"]["name"]);
				$extension = end($temp);
				error_log("-->$extension<--");
				$c = in_array($extension, $allowedExts);
				
				if ((($_FILES["file"]["type"] == "image/gif")
						|| ($_FILES["file"]["type"] == "image/jpeg")
						|| ($_FILES["file"]["type"] == "image/jpg")
						|| ($_FILES["file"]["type"] == "image/pjpeg")
						|| ($_FILES["file"]["type"] == "image/x-png")
						|| ($_FILES["file"]["type"] == "image/png"))
						&& ($_FILES["file"]["size"] < 200000)
						&& in_array($extension, $allowedExts)) {
					
					if ($_FILES["file"]["error"] > 0) {
						$errors[] = "Invalid file";
					} else {
						
						if (file_exists("upload/" . $_FILES["file"]["name"])) {
							$errors[] = $_FILES["file"]["name"] . " already exists. ";
						} else {
							move_uploaded_file($_FILES["file"]["tmp_name"],
							"upload/" . $_FILES["file"]["name"]);
							$_POST['file_path'] = "upload/" . $_FILES["file"]["name"];
						}
					}	
				}
			}				//print_r($_POST);

			
			$id_university 			= 	mysqli_real_escape_string($con, $_POST['id_university']);
			$title					= 	mysqli_real_escape_string($con, $_POST['title']);
			$description1			= 	mysqli_real_escape_string($con, $_POST['description1']);
			$description2			= 	mysqli_real_escape_string($con, $_POST['description2']);
			$reference_link			= 	mysqli_real_escape_string($con, $_POST['reference_link']);
			$attachment_link		= 	mysqli_real_escape_string($con, $_POST['attachment_link']);
			$course					= 	mysqli_real_escape_string($con, $_POST['course']);
			$attachement_path		=	'';
			if(!empty($_POST['file_path'])){
				$attachement_path 		= 	mysqli_real_escape_string($con, $_POST['file_path']);
			}
			

			function clean($string) {
				$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
				$return =  preg_replace('/[^A-Za-z0-9\-\_]/', '', $string); // Removes special chars.
				return $return;
			}
						
			
			
			
				
			
			$insert_query 	=	"INSERT INTO notification  
												(
												  	id_notification,
													id_university,
													title,
													description1,
													description2,													
													reference_link,
													attachment_link,
													attachement_path,
													approved,
													time_created,
													time_updated,
													course
												) VALUES 	
												(
													'',
													'$id_university',
													'".$title."',
													'".$description1."',
													'".$description2."',
													'".$reference_link."',
													'".$attachment_link."',
													'".$attachement_path."',
													'0',
													'".time()."',
													'".time()."',
													'".$course."'
															
												)";

			
			//echo $insert_query;
			if(mysqli_query($con,$insert_query)){
				$successes[] = "Thanks for providing information.";			
				print_r($successes);
			}else{
				$errors[] = $insert_query;
				print_r($errors);
			}
			
			
			
			echo $id_notification =  mysqli_insert_id($con);
			$r		=	mysqli_query($con, "select * from notification n, university u where n.id_university = u.id_university and n.id_notification =$id_notification order by id_notification desc limit 1");
			$row 	= 	mysqli_fetch_assoc($r);
			$filename 	=	$row['name']."_".$row['id_notification']."_".$row['state']."_".$title;
			$filename 	= 	clean($filename);
			//echo 'UPDATE notification SET seo_filename = '.mysqli_real_escape_string($con, $filename).' where id_notification = '.$id_notification;
			mysqli_query($con, 'UPDATE notification SET seo_filename = \''.mysqli_real_escape_string($con, $filename).'\' where id_notification = '.$id_notification);
				
			
			
		}

 $select_category 	=	get_select_options_data('university', 'id_university');
 mysqli_close($con);
?>

<html>
	<script type="text/javascript">
	    document.write("\<script src='http://code.jquery.com/jquery-latest.min.js' type='text/javascript'>\<\/script>");
	    
	    function fillSelectBoxTrigger(element){
		     //alert(' i am called, but i have lot of work to do.');
	    }
	    
	</script>
	<style>
	form.cmxform fieldset {
  margin-bottom: 10px;
}
form.cmxform legend {
  padding: 0 2px;
  font-weight: bold;
}
form.cmxform label {
  display: inline-block;
  line-height: 1.8;
  vertical-align: top;
}
form.cmxform fieldset ol {
  margin: 0;
  padding: 0;
}
form.cmxform fieldset li {
  list-style: none;
  padding: 5px;
  margin: 0;
}
form.cmxform fieldset fieldset {
  border: none;
  margin: 3px 0 0;
}
form.cmxform fieldset fieldset legend {
  padding: 0 0 5px;
  font-weight: normal;
}
form.cmxform fieldset fieldset label {
  display: block;
  width: auto;
}
form.cmxform em {
  font-weight: bold;
  font-style: normal;
  color: #f00;
}
form.cmxform label {
  width: 120px; /* Width of labels */
}
form.cmxform fieldset fieldset label {
  margin-left: 123px; /* Width plus 3 (html space) */
}
	</style>
	
	
		<div id='regbox'>
		<form action="up.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="form_subission" value="1">
		<fieldset style="width:800px;align:center;">
			<legend>Add University Notification</legend>
<p>
	  		<label for="category">University:</label>
			<?php echo $select_category; ?>
</p><p>
			
			<label for="course">Course :</label>
			<input type="texts" name="course" id="course">
</p><p>
			<label for="title">Notification Title :</label>
			<input type="text" name="title" id="title">
</p><p>			
			<label for="description1">Notification Details (Para1):</label>
			<textarea name="description1" id="description1" width="300" height="500"></textarea>
</p><p>			
			<label for="description2">Notification Details (Para2):</label>
			<textarea name="description2" id="description2" width="300" height="500"></textarea>
</p><p>			
			<label for="reference_link">University Website Link :</label>
			<input type="text" name="reference_link" id="reference_link">
</p><p>			
			<label for="attachment_link">University Attachment Link :</label>
			<input type="text" name="attachment_link" id="attachment_link">
</p><p>			
			<input type="submit" name="submit" value="Submit">
</p>
			</fieldset>

		</form></center>
		</div>
</div>
		<div id='bottom'></div>
		</div>
	</body>
</html>


<?php 

function get_select_options_data($table_name, $select_name, $selected_value = null){
	global $con;
	$r	=	mysqli_query($con, 'select * from '.$table_name);

	$selbox = '<select name="'.$select_name.'" onChange="fillSelectBoxTrigger(this)">';
	while($row = mysqli_fetch_assoc($r)){

		if(strtolower($row['name']) == strtolower($selected_value)){
			//echo "<br> MATCHED".strtolower($row['name']).$selected_value.'--';
			$selbox	.= '<option value=\''.$row["$select_name"].'\' selected="">'.$row["name"].'</option>';
		}else{
			$selbox	.= '<option value=\''.$row["$select_name"].'\'>'.$row["name"].'</option>';
		}

	}
	$selbox	.= '</select>';
	return $selbox;
}
?>
