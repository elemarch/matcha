<?php
	session_start();
	$G_OPT = array(
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	$G_PDO = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $G_OPT);
?>