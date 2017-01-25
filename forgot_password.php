<?php include 'includes/header.php' ?>

<?php 

    if (!empty($_GET['token'])) {
        $query = "SELECT * FROM cmg_tokens T INNER JOIN cmg_users U WHERE T.user_id=U.id AND T.value = '" . $_GET['token'] . "'";
        $table = mysql_getTable($query, $G_PDO);
        if ($table) {
            $username = $table["username"];
            echo '<form method="post" action="reset_password.php?username=' . $username . 'name="resetform" id="resetform">';
            echo '<label for="password">Enter your new password twice</label><br>';
            echo '<input type="password" name="password1" id="password1"><br>';
            echo '<input type="password" name="password2" id="password2"><br>';
            echo '<input type="submit" name="register" id="register" value="Ok">';
            echo '</form>';
        }
        else {
            echo '<h1>Token not valid</h1>';
            echo 'Your token is outdated or doesn\'t exist.<br>';
            echo '<a class="button" href="index.php">Back to main page</a>' ;
        }
    }
    elseif (!empty($_POST['text']) && !empty($_POST['type'])) {
        // Generate a token
        $token = hash("sha256", $_POST['text'] . time());
        
        // Send an email to the user
        if (!strcmp($_POST['type'], 'username')) {
            $query = "SELECT * FROM cmg_users WHERE username = '" . $_POST['text'] . "'";
            $table = mysql_getTable($query, $G_PDO);
            $c_user = new User($table[0]);

        }
        else {
            $query = "SELECT * FROM cmg_users WHERE mail = '" . $_POST['text'] . "'";
            $table = mysql_getTable($query, $G_PDO);
            $c_user = new User($table[0]);
        
        }
        if ($c_user && $email = $c_user->getMail()) {
            mail($email, "CamaGru! - Password reset", "Hi, here is your link to reset your password.\nhttp://127.0.0.1:8080/forgot_password.php?token=" . $token);
            echo "<h1>Mail was sent to " . $email . ".</h1> Don't forget to check your spams !<br>" ;
            echo '<a class="button" href="index.php">Back to main page</a>' ;
            $query = $G_PDO->query("INSERT INTO cmg_tokens (value, user_id) VALUES('" . $token . "', '" . $c_user->getId() . "')");
        }
        else {
            echo '<h1>Error</h1>';
            echo '<p>User could not be found.</p>' ;
            echo '<a class="button" href="index.php">Back to main page</a>' ;
        }
    }
    else { ?>

    <h1>Password forgotten ?</h1>
    <p>Don't worry, we'll help you to change it. First, tell us your name or your email adress :</p>
    <form method="post" action="forgot_password.php" name="forgotform" id="forgotform"><fieldset>
    <input type="text" name="text" id="text"><br>
    <input type="radio" name="type" value="mail"> This is my Mail<br>
    <input type="radio" name="type" value="username" checked> This is my Username<br>
    <input type="submit" name="register" id="register" value="Go!">
    </fieldset></form>


    <?php }

?>

<?php include 'includes/footer.php' ?>