<?php include 'includes/header.php' ?>

<?php
	if (!$G_USER->isConnected()) {
		include "index/section1.php";
		include "index/section2.php";
		include "index/section3.php";
		include "index/section4.php";
	} 
	else {
		include "dashboard/section1.php";
		include "dashboard/section2.php";
	}
?>
			

			

<?php include 'includes/footer.php' ?>