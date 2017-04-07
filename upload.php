<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Image upload with PHP</title>
</head>

<body>
<?php 
	require_once("db_con.php");
	
	$cmd = filter_input(INPUT_POST, 'upload');
	
	// variable to check if there were upload problems/errors!
	$uploadOk = 0;
	
	if($cmd){
		
		// storing the path to your image directory
		$target_dir = "images/";
 		$target_file = $target_dir . basename($_FILES['fileToUpload']['name']); //specifies the path of the file to be uploaded (i.e. images/Yoda_walk.gif)
		
		// Check if file is an image
		 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		 if($check !== false) {
		 echo "File is an image type " . $check["mime"] . ". ";
		 $uploadOk = 1;
		 } else {
		 echo "File is not an image. ";
		 $uploadOk = 0;
		 }
		
		// Check if file already exists
		 if (file_exists($target_file)) {
		 echo "The file already exists. ";
		 $uploadOk = 0; 
		 } 
		
		// Check if $uploadOk is set to 0 by an error
		 if ($uploadOk == 0) {
		 echo "Sorry, your file was not uploaded. ";
		 // if everything is ok, try to upload file
		 } else {
		 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		// the query inserting target path into database!
			 
			$stmt = $con->prepare("INSERT INTO images (url) VALUES (?)");
			$stmt->bind_param("s", $target_file);
			$stmt->execute();
			// close statement
			$stmt->close();

		 echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		 } else {
		 echo "Sorry, there was an error uploading your file.";
		 	}
		 }	
		
	// end if cmd:	
	}
	
?>
<!-- Enctype multipart MUST be used in connection with a file/image upload -->
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<p><input type="file" name="fileToUpload"></p>
<p><input type="submit" name="upload" value="Upload"></p>
</form>

<hr>

<p>Display an image from the database:</p>
<?php 
	
$stmt = $con->prepare("SELECT url FROM images");
$stmt->execute();
$stmt->bind_result($url);

while($stmt->fetch()){
	
	echo '<p><img src="' . $url . '" width="200"></p>';
}

$stmt->close();
$con->close();
	
?>
</body>
</html>