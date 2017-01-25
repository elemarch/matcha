<?php
	echo "<div class='row container-fluid'>";
	$G_USER->printCard("Mon Profil");

	$visit = mysql_getTable("SELECT visitor_id FROM visites WHERE target_id=" . $G_USER->getId() . " ORDER BY date DESC LIMIT 1", $G_PDO);
	$visit = new User (intval($visit[0]["visitor_id"]), $G_PDO);
	$visit->printCard("Dernière visite
		<a class='btn btn-primary fa fa-plus-circle float_right' 
		href='visites.php'></a>");

	$visit = mysql_getTable("SELECT target_id FROM visites WHERE visitor_id=" . $G_USER->getId() . " ORDER BY date DESC LIMIT 1", $G_PDO);
	$visit = new User (intval($visit[0]["target_id"]), $G_PDO);
    $visit->printCard("Dernier profil vu
		<a class='btn btn-primary fa fa-plus-circle float_right' 
		href='historique.php'></a>");

	$visit = mysql_getTable("SELECT user_id FROM likes WHERE target_id=" . $G_USER->getId() . " ORDER BY date DESC LIMIT 1", $G_PDO);
	$visit = new User (intval($visit[0]["user_id"]), $G_PDO);
	$visit->printCard("Dernier Meow
		<a class='btn btn-primary fa fa-plus-circle float_right' 
		href='likelist.php'></a>");
	echo "</div>";
?>

