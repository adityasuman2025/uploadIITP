<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "Upload Module IIT Patna";
	
	$website = $_SERVER['HTTP_HOST']; //dns address of the site 
	if($website == "localhost")
	{	
		$project_address = "";

		$photo_folder = "../key_issue_api/stud_img/";
	}
	else if($website = "mngo.in")
	{
		$project_address = "";
		
		$photo_folder = "../key_issue_api/stud_img/";
	}
	else
	{
		$project_address = "/var/www/html/upload/"; //change this address when deplying somewhere else

		$photo_folder = "key_issue_api/stud_img/";
	}	
?>