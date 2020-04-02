<?php
	include_once 'universal.php';

	if(isset($_POST['new_name']))
	{
		$new_name = $_POST['new_name'];

	//creating the required folder if folder is not present	
		$file_upload_address = $project_address . "../" . $upload_address;

		$fold_status = 0;	
		if (!file_exists($file_upload_address)) 
		{
			$oldmask = umask(0); //for giving all permission to the folder
		    if(mkdir($file_upload_address, 0777, true))
		    {
		    	umask($oldmask);

		    	$fold_status = 1;
		    }		    			   
		}
		else
			$fold_status = 1;

	//uploading file	
		if($fold_status == 1)//folder where file is to be uploaded exists
		{
			if($_FILES['file']["name"] != '')
			{
			//getting new name of the file
				$upload_location = $file_upload_address . $new_name;

			//adding uploaded file info in db
				if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_location))
				{
					echo 1;
				}
				else
					echo 0;
			}	
			else
				echo 0; //file uploading failed
		}
		else
			echo -2; //file uploading directory not present in server
	}
	else
		echo -1;
?>