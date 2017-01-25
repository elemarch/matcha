<div class="container-fluid" id="section4">
	<h1>Nous rejoindre</h1>
	<form id="subform" method="post" action="register.php" enctype="multipart/form-data">
		<div class="col col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">Informations de compte</div>
				<div class="panel-body">
					<label for="mail">E-Mail</label>
					<a data-toggle="popover" 
					data-content="Votre e-mail ne sera pas visible par les autres utilisateurs.">
					<i class="fa fa-question-circle" aria-hidden="true"></i>
				</a><br>
				<input type="email" name="mail" id="mail" required> <br>
				<label for="username">Pseudo</label>
				<a data-toggle="popover" 
				data-content="Votre nom d'utilisateur doit contenir au moins trois lettres et uniquement des chiffres et des lettres.">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
			</a><br>
			<input type="text" name="username" id="username" required> <br>
			<label for="password1">Mot de passe</label>
			<a data-toggle="popover" 
			data-content="Votre mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.">
			<i class="fa fa-question-circle" aria-hidden="true"></i>
		</a><br>
		<input type="password" name="password1" id="password1" required><br>
		<input type="password" name="password2" id="password2" required><br>
	</div>
</div>
</div>
<div class="col col-sm-6">
	<div class="panel panel-default">
		<div class="panel-heading">Profil</div>
		<div class="panel-body">
			<label for="age">Âge en mois</label> <br>
			<input type="number" name="age" id="age" required> <br>

			<div class="sandbox">
				<label for="select-gender">Sexe</label>
				<select name="gender" id="select-gender" placeholder="Selectionnez ou tapez..." required>
					<option value="">Selectionnez ou tapez...</option>
					<?php
					$gender = mysql_getTable("SELECT * FROM gender", $G_PDO);

					foreach ($gender as $key => $value) {
						echo '<option value="' . $value["value"] . '">' . $value["value"] . '</option>';
					}
					?>
				</select>
			</div>

			<div class="sandbox">
				<label for="select-attract">Intéressé(e) par...</label>
				<select name="attraction[]" id="select-attract" placeholder="Selectionnez ou tapez..." required>
					<option value="">Selectionnez ou tapez...</option>
					<?php
					$gender = mysql_getTable("SELECT * FROM gender", $G_PDO);

					foreach ($gender as $key => $value) {
						echo '<option value="' . $value["value"] . '">' . $value["value"] . '</option>';
					}
					?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="col col-sm-8">
	<div class="panel panel-default">
		<div class="panel-heading">Informations complémentaires</div>
		<div class="panel-body">
			<div class="sandbox">
				<label for="input-tags">Tags</label>
				<a data-toggle="popover" 
				data-content="Indiquez vos goûts, ce que vous aimez faire...">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
			</a>
				<select name="tags[]" id="select-tags" placeholder="Selectionnez ou tapez..." required>
					<option value="">Selectionnez ou tapez...</option>
					<?php
					$gender = mysql_getTable("SELECT * FROM tags", $G_PDO);

					foreach ($gender as $key => $value) {
						echo '<option value="' . $value["value"] . '">' . $value["value"] . '</option>';
					}
					?>
				</select>
		</div>

		<div class="sandbox">
			<label for="description">Description</label>
			<textarea  name="description" required>Ecrivez quelques lignes....</textarea>
		</div>
	</div>
</div>
</div>
<div class="col col-sm-4">
	<div class="panel panel-default">
		<div class="panel-heading">Photo de Profil</div>
		<div class="panel-body">
			<input type="file" name="datafile" size="500" accept="image/jp*" required><br>
			<p>La photo de profil sera redimensionnée automatiquement. Nous conseillons un format carré. Le fichier doit être de type jpeg et peser moins de 500ko.</p>
		</div>
	</div>
	<input type="submit" name="submit-form" value="Je m'inscris !">
</div>
</form>
</div>

<script type="text/javascript">
	$('#select-gender').selectize({
		create: true,
		sortField: 'text'
	});
	
	$('#select-attract').selectize({
		create: true,
		maxItems: 999
	});
	
	$('#select-tags').selectize({
		delimiter: ',',
		persist: false,
		maxItems: 999,
		create: function(input) {
			return {
				value: input,
				text: input
			}
		}
	});
</script>