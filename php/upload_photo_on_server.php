<?php
	include_once "universal.php"; 

	if(isset($_COOKIE['rollno']))
	{		
	//getting cookies
		$rollno = $_COOKIE['rollno'];

		if($rollno != "")
		{
		//getting folder where the file is to be uploaded	
			$dir_to_upload = "";			
			$file_id = "file";
			$dir_to_upload = $project_address . "../" . $photo_folder;

		//creating the required folder if folder is not present	
			$fold_status = 0;	
			if (!file_exists($dir_to_upload)) 
			{				
				$oldmask = umask(0); //for giving all permission to the folder
			    if(mkdir($dir_to_upload, 0777, true))
			    {
			    	umask($oldmask);

			    	$fold_status = 1;

			    	//echo "folder created";
			    }	
			    else
			    {
			    	//echo "fail to make folder";
			    }	    			   
			}
			else
			{
				//echo "folder already exist";
				$fold_status = 1;
			}					

			if($fold_status == 1)//folder where file is to uploaded exists
			{
				if($_FILES[$file_id]["name"] != '')
				{
				//getting name of the file								
					$file_extension = strtolower( substr( strrchr($_FILES[$file_id]['name'], '.') ,1) ); //extension name of the file
					
					$new_name = strtolower($rollno) . "." . $file_extension; 
					$upload_location = $dir_to_upload . $new_name;
					
				//uploading file 	
					if(move_uploaded_file($_FILES[$file_id]['tmp_name'], $upload_location))
						echo 1;
					else
						echo 0;
				}	
				else
				{
					echo 0; //file uploading failed
				}		
			}
			else
			{
				echo -2; //file uploading directory not present in server
			}
		}
		else
		{
			echo -1;
			//array_push($errors, "Something went wrong");
		}	
	}
	else
	{
		echo -1;
		//array_push($errors, "Something went wrong");
	}
?>

