<?php
	function checkMenuPage($name) {
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if (strpos($url, $name) !== false) {
			    echo '<li class="active"><a ';
			    return true;
		}
		else{
				echo '<li><a href="' . $name . '.php"';
				return false;
		}
	}

	function checkPassword($pwd) {
		if (strlen($pwd) < 8) { return false; }
		if (!preg_match( '/[A-Z]/', $pwd)) { return false; }
		if (!preg_match( '/[a-z]/', $pwd)) { return false; }
		if (!preg_match( '/[0-9]/', $pwd)) { return false; }
		return true;
	}

	function checkPicture($file) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    	if($check == false) { $error = 1; } //if image is or not a fake img
		if ($_FILES["fileToUpload"]["size"] > 500000) { $uploadOk = 1; } //check if file is too big
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    		$error = 1;
		}
		return $error;
	}

	function checkUsername($name) {
		if (strlen($name) < 3) { return false; }
		if (preg_match( '/[^\w]s/', $name)) { return false; }
		return true;
	}
?>