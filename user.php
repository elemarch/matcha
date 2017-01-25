<?php include 'includes/header.php' ?>

<?php
	if ($G_USER->isConnected()) {
		if (isset($_GET["id"]))  { 
			$user = new User (intval($_GET["id"]), $G_PDO);
			if (!($user->getID() == $G_USER->getID())) {
				$query = "INSERT INTO visites (target_id,visitor_id) VALUES(" . intval($_GET["id"]) . "," . $G_USER->getId() . ")";
				$G_PDO->query($query);
			}
		}
		else {
			$user = $G_USER;
		}
	}
	else {
		echo '<h1>Erreur</h1>';
		echo '<p>Pour voir les profils de nos membres, vous devez vous connecter.</p>';
		echo '<p><a href="index.php#sectionq1" class="btn btn-primary">Se connecter</a>';
		echo '<a href="index.php#section2" class="btn btn-primary">Créer un compte</a></p>';
		return 0;
	}

	if (isset($_GET['like'])){
			$G_PDO->query("DELETE FROM likes WHERE user_id=" . $G_USER->getId() . " AND target_id=" . $user->getId());
		if ($_GET['like'] == 'true' ) {
			$query = $G_PDO->prepare("INSERT INTO likes (target_id, user_id) VALUES(:target,:user)");
			$values = array(
                ':user' => $G_USER->getId(),
                ':target' => $user->getId()
                );
			$query->execute($values);
		}
	}
?>


<div class="row container-fluid">
<?php $user->printCard() ?>

	<div class="col col-sm-9">
	<?php
		if (!($G_USER->getId() == $user->getId())) {
			$query = mysql_getTable("SELECT * FROM likes 
				WHERE target_id=" . $G_USER->getId() . " AND user_id=" . $user->getId() . "
				OR target_id=" . $user->getId() . " AND user_id=" . $G_USER->getId() ,
				$G_PDO);
			echo "<div class='alert alert-";

			if (sizeof($query) == 0) {		echo "warning"; }
			else if (sizeof($query) == 1) {	echo "info";	}
			else {							echo "danger";	}

			echo "'>";
			if ($query[0]['user_id'] == $G_USER->getId() || $query[1]['user_id'] == $G_USER->getId()) {
				echo '<a class="btn btn-default btn-dislike" 
				href="http://127.0.0.1:8080/matcha/user.php?id=' . $user->getId() . '&like=false">
				<i class="fa fa-times" aria-hidden="true"></i> ???
				</a> ';
			}
			else {
				echo '<a class="btn btn-default btn-like"
				href="http://127.0.0.1:8080/matcha/user.php?id=' . $user->getId() . '&like=true">
				<i class="fa fa-heart" aria-hidden="true"></i>Meow
				</a> ';
			}

			if (sizeof($query) == 2) {
				echo "Vous ronronnez à deux !";
			}
			else if ($query[0]['user_id'] == $G_USER->getId() || $query[1]['user_id'] == $G_USER->getId()) {
				echo "Vous aimeriez bien ronronner avec ce chat.";
			}
			else if ($query[0]['user_id'] == $user->getId() || $query[1]['user_id'] == $user->getId()) {
				echo "Ce chat aimerait bien ronronner avec vous.";
			}
			else {
				echo "Ce chat ne vous connais pas.";
			}
			?>
			<div class="dropdown float_right">
				<button type="button" class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
					<i class="fa fa-flag" aria-hidden="true"></i> 
					Signaler \
				</button>
				<ul class="dropdown-menu">
					<li><a href="#">Faux profil</a></li>
					<li><a href="#">Harcèlement</a></li>
					<li><a href="#">Autre</a></li>
				</ul>
			</div>
			<?php
			echo "</div>";
		}
	?>
		<div class="row">
			<div class="desc-box col col-md-6">
				<h2>Description</h2>
				<p><?php echo $user->getDescription() ?></p>
			</div>
			<div class="col col-md-6">
				<h2>Mes photos</h2>
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
						<li data-target="#myCarousel" data-slide-to="4"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php
								echo '<div class="item active">';
								echo '<img src="medias/photos/' . $user->getPhotos("profile") . '">';
								echo '</div>';
								$i = 0;
							foreach ($user->getPhotos() as $key => $value) {
								$i++;
								if ($i == 1) {
									continue;
								}
								echo '<div class="item">';
								echo '<img src="medias/photos/' . $value . '">';
								echo '</div>';
							}
						?>
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="container-fluid align-center tag-box">
<div class="col-sm-6">
	<h2>Intéressé(e) par...</h2>
	<?php
		foreach ($user->getAttraction() as $key => $value) {
			echo "<span class='tag'>";
			echo $value;
			echo "</span>";
		}
	?>
</div>
<div class="col-sm-6">
	<h2>Aime</h2>
	<?php
		foreach ($user->getTags() as $key => $value) {
			echo "<span class='tag'>";
			echo $value;
			echo "</span>";
		}
	?>
</div>
</div>

<?php include 'includes/footer.php' ?>