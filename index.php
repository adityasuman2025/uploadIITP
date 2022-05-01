<?php
	include_once 'php/universal.php';
?>

<html>
	<head>
		<title><?php echo $project_title; ?></title>

		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/style.css" rel="stylesheet"/>
		<link rel="icon" href="img/logo.png" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		
		<meta name="viewport" content="width=device-width, initial-scale= 1">	
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="English">
		<meta name="author" content="Aditya Suman">	
	</head>

	<body>
	<!--------navigation bar---->
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      	<a class="navbar-brand">
		      		<div class="row">		      	
		      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 x_m-p header_bar_title">
		      				<img src="img/logo.png" class="" />
		      				<!-- Indian Institute Of Technology Patna -->
		      				<?php echo $project_title; ?>
		      			</div>
		      		</div>
				</a>
		    </div>
		  </div>
		</nav>

	<!--------main container------>
		<div class="container-fluid">	
			<div class="row course_card">
				<label for="file">Upload File</label>
				<input type="file" name="file" id="file">
				<br />

				<a href="" id="upload_link" target="_blank"></a>
				<button class="btn btn-success" style="width: 60px; height: 35px; display: none" id="copy_btn">copy</button>
				<br /><br />

				<div class="error"></div>				
			</div>
		</div>

	<!---------script--------->
		<script type="text/javascript">
			const upload_address = "<?php echo $upload_address ?>";
			const allowed_extensions = <?php echo json_encode($allowed_extensions) ?>;

		//for uploading a file
		    $(document).on('change', '#file', function() {
		      	$('.error').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\">");

		    //getting uploaded file info
		      	var property = document.getElementById("file").files[0];
		      	var image_name = property.name;
		        var image_extension = image_name.split('.').pop().toLowerCase();

				if (!allowed_extensions.includes(image_extension)) {
					$('.error').text('This file is not allowed to upload').css("color", 'red');
					return;
				}

	        //removing special characters from name of the file
				var only_name = image_name.substring(image_name.lastIndexOf('/')+1, image_name.lastIndexOf('.'));
	        	// only_name = only_name.replace(/[~!@#$%^&*()_+-=\[\]{}\\|;:'",./<>?/*-+ 	`]/g, '_');
	        	only_name = only_name.replace(/[^a-zA-Z0-9]/g, '_');

		    //enrypting the new name of the file
		      	$.post("php/encrypt_api.php", { text: Math.floor(Date.now() / 1000), action: "encrypt" }, function(encrypted_text) {
		      		var new_name = only_name + "_" + encrypted_text + "." + image_extension;
		      		
		      	//showing the link of the upload file
		      		var web_address = window.location.href   // Returns the page URL (https://example.com/bro)
		      		var link = upload_address + new_name;
					var complete_link = web_address + link;

		      	//sending upload request to api
					var form_data = new FormData();
					form_data.append("file", property);
					form_data.append("new_name", new_name);
					$.ajax({
						url: "php/upload_file_on_server.php",
						method: "POST",
						data: form_data,
						contentType: false,
						cache: false,
						processData: false,
						beforeSend:function() {
							$('.error').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\" /></br>Uploading File").css('color', '#f1f1f1');
						},
						success: function(data) {
							// console.log(data);

							if(data == 0)
							{
								$('.error').text('Failed to upload file').css("color", 'red');
							}
							else if(data == -2)
							{
								$('.error').text("File uploading directory not present on server").css("color", 'red');
							}
							else if(data == -1)
							{
								$('.error').text("Something went wrong").css("color", 'red');
							}
							else if(data == 1)
							{
								$('#upload_link').text(complete_link);
								$('#upload_link').attr('href', complete_link);
								$('#copy_btn').fadeIn(0);

								$('.error').text("File succesfully uploaded").css("color", 'green');
							}
							else
								$('.error').text("Unknown error").css("color", 'red');
						},
						error: function(request,status,errorThrown) {
							$('.error').text("status: " + status + ", " + errorThrown).css("color", 'red');
						}
					});
		      	});
		    });

		//on clicking on copy btn
			$('#copy_btn') .on("click", function()
			{				
				var link = $('#upload_link').attr('href');

				//copy to clipboard stuffs	
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val(link).select();
				document.execCommand("copy");
				$temp.remove();

				alert("copied");
			});
		</script>
	</body>
</html>