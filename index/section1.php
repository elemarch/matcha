<div class="container-fluid banner" id="section1">
	<div class="col-sm-6"></div>
	<div class="col-lg-2 col-sm-4">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
							Nous rejoindre
						</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse in">
					<div class="panel-body">
						<p>Créez votre compte en quelques clics, et rejoignez instantanément plusieurs milliers de chats à travers la France et le monde.</p>
						<a href="#section4" class="btn btn-primary">Créer mon compte !</a>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
							Se connecter
						</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<div class="panel-body">
						<form method="post" action="login.php" name="loginform" id="loginform">
							<label for="username">Pseudo</label><br>
							<input type="text" name="username" id="username" required><br>
							<label for="password">Password</label><br>
							<input type="password" name="password" id="password" required><br>
							<input type="submit" name="register" id="register" value="Log In" class="btn btn-primary">
						</form>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
							J'ai oublié mon mot de passe
						</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
					<div class="panel-body">
						Entrez votre adresse mail :
						<form method="post" action="forgot_password.php" name="forgotform" id="forgotform">
							<input type="text" name="text" id="text"><br>
							<input type="submit" name="register" id="register" value="Go!" class="btn btn-primary">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>