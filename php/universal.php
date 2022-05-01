<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "Upload Module IIT Patna";
	$allowed_extensions = array('zip', 'rar', "mp4", "png", "jpeg", "jpg");
	
	$website = $_SERVER['HTTP_HOST']; //dns address of the site 
	if($website == "localhost") {	
		$project_address = "";
		$upload_address = "uploads/";
	} else if($website = "mngo.in") {
		$project_address = "";
		$upload_address = "uploads/";
	} else {
		$project_address = "/var/www/html/upload/"; //change this address when deplying somewhere else
		$upload_address = "uploads/";
	}	
?>