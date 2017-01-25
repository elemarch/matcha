<?php
$error = 0;

// IF A PHOTO IS INDICATED FOR UPLOAD CAMERA IS IGNORED
if (isset($_FILES["pic"]) && $_FILES["pic"]["size"]) {

    $check = getimagesize($_FILES["pic"]["tmp_name"]);
    $original = basename($_FILES["pic"]["name"]);
    $type = pathinfo($original,PATHINFO_EXTENSION);

    if($check == false) {
        echo "<h1>Error</h2>This is not an image.";
        $error = 1;
    }
    elseif ($_FILES["pic"]["size"] > 100000) {
        echo "<h1>error 2</h2>Image is too big.";
        $error = 2;
    }
    elseif ($type != "png") {
        echo "<h1>Error</h2>Image is not a png.";
        $error = 3;
    }
    else {
        //create db entry
        $G_PDO->query('INSERT INTO cmg_photos (creator_id) VALUES (' . $G_CNX->getId() . ')');
        $G_PDO->query('UPDATE cmg_users SET photos = photos + 1 WHERE id = ' . $G_CNX->getId()) ;
        
        //get photo and id
        $photo = mysql_getTable('SELECT * FROM cmg_photos WHERE creator_id = ' . $G_CNX->getId() . ' ORDER BY creation DESC', $G_PDO);
        $pid = $photo[0]['id'];
        
        //upload file
        $bl_name = "medias/photos/pht_" . $pid . ".png" ;
        move_uploaded_file($_FILES["pic"]["tmp_name"], $bl_name);
        //at this stade our background image is not the good size

        $dim = getimagesize($bl_name);
        preg_match_all('/"([^"]+)"/', $dim[3], $dim);
        Photo::resize($bl_name, $dim[1][0], $dim[1][1]);
    }
}
// ELSE, IF USE OF THE CAMERA
elseif (isset($_POST['img_data']) && !empty($_POST['img_data'])) {
    //get data
    $imageData=$_POST['img_data'];

    //filter and secure data
    $filteredData=$G_PDO->quote(substr($imageData, strpos($imageData, ",")+1));
    $filteredData=substr($filteredData, 1, -1);

    //decode data
    $unencodedData=base64_decode($filteredData);
    if ($unencodedData) {
        //create db entry
        $G_PDO->query('INSERT INTO cmg_photos (creator_id) VALUES (' . $G_CNX->getId() . ')');
        $G_PDO->query('UPDATE cmg_users SET photos = photos + 1 WHERE id = ' . $G_CNX->getId()) ;
        
        //get photo and id
        $photo = mysql_getTable('SELECT * FROM cmg_photos WHERE creator_id = ' . $G_CNX->getId() . ' ORDER BY creation DESC', $G_PDO);
        $pid = $photo[0]['id'];

        //save data - the image here is now the "back layer" of our future image
        $bl_name = 'medias/photos/pht_' . $pid . '.png';
        $file = fopen($bl_name, 'wb');
        fwrite($file, $unencodedData);
        fclose($file );
    }
    else {
        echo '<h1>Error</h2>Your photo is not valid. Please check your camera, or upload another picture.';
        $error = 5;
    }
}
else {
    $error = 6; 
    echo '<h1>Error</h2>Undefined.';
}

if (!$error) {
//get the front layer name
$fl_name = "medias/layers/layer_" . $_POST['front_layer'] . ".png";

//create PNGs
    $front = imagecreatefrompng($fl_name);
    $front_w = imagesx($front);
    $front_h = imagesy($front);
    imagealphablending($front, true);
    imagesavealpha($front, true);

    $back = imagecreatefrompng($bl_name);
    $back_w = imagesx($back);
    $back_h = imagesy($back);

    //create final image
    imagecopy($back, $front, 0, 0, 0, 0, $front_w, $front_h);
    imagepng($back, $bl_name, 0);
    imagedestroy($back);
    imagedestroy($front);
}
  ?>