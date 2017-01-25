<?php
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
		$name = quoteText($_SESSION['Username'], $G_PDO);
    	$G_USER = new User ($name, $G_PDO, true);
    	$G_USER->setConnected(true);
	}
	else { $G_USER = new User (NULL, $G_PDO); }
?>