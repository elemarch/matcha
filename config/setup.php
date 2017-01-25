<?php
	include '../functions/f_db.php' ;
	include '../functions/class_user.php';
	include 'database.php' ;
	include 'connect.php' ;
/*
cmg_users		id		username		password	mail		photos 		creation
cmg_tokens 		id 		value			user_id		creation
cmg_photos		id		creator_id		likes 		comments 	creation
cmg_comments	id 		content 		photo_id	creator_id	creation
cmg_likes		id 		user_id			photo_id
*/

//empty database
$table = ['users', 'tokens', 'gender', 'tags', 'likes', 'visites'] ;
$to_drop = 'DROP TABLE ' ;

foreach ($table as $value) {
	$row = mysql_getTable("SELECT * FROM information_schema.TABLES WHERE (TABLE_SCHEMA = 'matcha') AND (TABLE_NAME = '" . $value . "')", $G_PDO);
	if (!isset($row[0][0]) && $row[0]) {	//table exist
		$to_drop .= $value . ', ' ;
	}
}

$to_drop = substr($to_drop, 0, -2);

if (strcmp($to_drop, 'DROP TABL')) {
	echo 'One ore more table already exist. Clearing. <br>' ;
	$G_PDO->query($to_drop);
}
else {
	echo 'None of the table actually exist. Creating them directly. <br>' ;
}

//create table
$genders = ['Asexué','Androgyne','Femelle','Genderfluid','FTM','Mâle','MTF','Non-binaire','Pansexué','Transgenre Femelle','Transgenre Mâle','Helicoptère Apache'];

$tag_list = ['dodo','le point rouge', 'mon humain', 'manger', 'chasser', 'les souris', 'miauler', 'renverser', 'gratter aux portes', 'les croquettes', 'dominer le monde', 'cracher', 'me battre', 'les ninjas', 'star wars', 'le vendredi', 'voyager', 'mordre', 'dormir', 'glander', 'jouer', 'les jeux videos', 'chanter', 'écrire'];

echo 'Creating USERS table...<br>';

$query = "CREATE TABLE users
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	username VARCHAR(20) NOT NULL, 
	password VARCHAR(64) NOT NULL, 
	mail VARCHAR(300) NOT NULL, 
	connected BOOLEAN,
	gender VARCHAR(20) NOT NULL,
	rds INT,
	age INT,
	description TEXT,
	photoP VARCHAR(100),
	photoA VARCHAR(100),
	photoB VARCHAR(100),
	photoC VARCHAR(100),
	photoD VARCHAR(100),
	attraction TEXT,
	tags TEXT,
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)" ;

$G_PDO->query($query);

echo 'Creating TOKENS table...<br>';

$query = 'CREATE TABLE tokens (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	value VARCHAR(64) NOT NULL,
	user_id INT NOT NULL,
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)' ;
$G_PDO->query($query);

echo 'Creating GENDER table...<br>';

$query = 'CREATE TABLE gender (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	value VARCHAR(20) NOT NULL
)' ;
$G_PDO->query($query);

$query = "INSERT INTO gender (value) VALUES('";
foreach ($genders as $key => $value) {
	$query .= $value . "'),('";
}
$query = substr($query, 0, -3);
$G_PDO->query($query);

echo 'Creating TAGS table...<br>';

$query = 'CREATE TABLE tags (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	value VARCHAR(20) NOT NULL
)' ;
$G_PDO->query($query);

$query = "INSERT INTO tags (value) VALUES('";
foreach ($tag_list as $key => $value) {
	$query .= $value . "'),('";
}
$query = substr($query, 0, -3);
var_dump($query);
$G_PDO->query($query);

echo 'Creating LIKES table...<br>';

$query = 'CREATE TABLE likes (
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	target_id INT NOT NULL,
	user_id INT NOT NULL
)' ;
$G_PDO->query($query);

echo 'Creating VISITS table...<br>';

$query = 'CREATE TABLE visites (
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	target_id INT NOT NULL,
	visitor_id INT NOT NULL
)' ;
$G_PDO->query($query);

db_fill_users(50, $genders, $tag_list, $G_PDO);
db_create_views(5000, $G_PDO);
db_create_likes(50, $G_PDO);

echo 'Done ! You can now navigate through my <a href="">Matcha!</a><br>';
?>