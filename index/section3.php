<div class="container-fluid" id="section3">
	<h1>Ils sont sur le site !</h1>
	<?php
		$query = mysql_getTable("SELECT * FROM users WHERE rds > 70 ORDER BY rds DESC LIMIT 8", $G_PDO);
		echo '<div class="row">';
		$i = 0;
		foreach ($query as $key => $value) {
			$i++;
			if ($i == 5) {
				echo '</div><div class="row">';
			}
			$user = new User ($value['username'], $G_PDO);
			$user->printCard();
		}
		echo '</div>';
	?>
</div>