<?php include 'includes/header.php' ?>

<div class="container-fluid row">
	<div class="col-md-8">
		<h1>Informations de compte</h1>
		<form>
			Adresse mail <input type="mail" value=<?php echo '"' . $G_USER->getMail() . '"' ?>>
		</form>
	</div>
</div>

<?php include 'includes/footer.php' ?>