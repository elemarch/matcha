<?php include 'includes/header.php' ?>

<?php 
if (    !empty($_POST["mail"])
    &&  !empty($_POST["username"])
    &&  !empty($_POST["password1"])
    &&  !empty($_POST["password2"])
    &&  !empty($_POST["age"])
    &&  !empty($_POST["gender"])
    &&  !empty($_POST["attraction"])
    &&  !empty($_POST["tags"])
    &&  !empty($_POST["description"])
    &&  !empty($_POST["submit-form"])
    &&  !empty($_FILES["datafile"])
){
    //2 protect data
    $post_data = quoteArray($_POST, $G_PDO);

    //3 check if each data is correct
    $error = 0;

    echo "<ul class='errlist'>";
        // if pass match
    if (strcmp($post_data["password1"], $post_data["password2"])) {
        echo '<li>Vos mots de passe ne correspondent pas. Veuillez réessayer.</li>';
        $error = 1; 
    }
    
        //if pass is secure enough
    if (!checkPassword($post_data["password1"])) {
        echo "<li>Votre mot de passe n'est pas assez sécurisé. Vérifiez qu'il contient : <ul>";
            echo "<li>Au moins 8 caractères</li>";
            echo "<li>Au moins une lettre majuscule</li>";
            echo "<li>Au moins une lettre minuscule</li>";
            echo "<li>Au moins un chiffre</li>";
        echo "</ul></li>";
        $error = 1; 
    }

        //if mail already taken
    $mail = mysql_getTable("SELECT * FROM users WHERE mail = '" . $post_data["mail"] . "'", $G_PDO);
    if ($mail) {
        echo "<li>Cette adresse mail est déjà utilisée</li>";
        $error = 1; 
    }
        //if username is long enough etc
    if (!checkUsername($post_data["username"])) {
        echo "<li>Votre pseudo est incorrect. Vérifiez : <ul>";
            echo "<li>Qu'il contient au moins 3 caractères</li>";
            echo "<li>Qu'il ne contient que des lettres ou des chiffres, sans accent</li>";
        echo "</ul></li>";
        $error = 1; 
    }
        //if username already taken
    $name = mysql_getTable("SELECT * FROM users WHERE username = '" . $post_data["username"] . "'", $G_PDO);
    if ($name) {
        echo "<li>Ce pseudo est déjà utilisé</li>";
        $error = 1; 
    }

        //if cat is a child
    if (intval($post_data["age"]) < 6) {
        echo "<li>Nous n'acceptons que les chats majeurs, soit de 6 mois ou plus.</li>";
        $error = 1; 
    }

        //if image is not an image
    $img = getimagesize($_FILES["datafile"]["tmp_name"]);
    if (!$img) {
        echo "<li>Le fichier uploadé n'est pas une image.</li>";
        $error = 1; 


    }

        //if image is too big
    if ($_FILES["datafile"]["size"] > 52428800) {
        echo "<li>L'image est trop grosse. La limite est de 500kb</li>";
        $error = 1; 
    }

        //if image is not jpg
    $original = basename($_FILES["datafile"]["name"]);
    $type = pathinfo($original,PATHINFO_EXTENSION);
    if ($type != "jpg" && $type != "jpeg") {
        echo "<li>L'image que vous avez envoyé n'est pas au bon format. Nous n'acceptons que les jpg ou jpeg.</li>";
        $error = 1; 
    }
    echo "</ul>";
    if ($error) { ?>
        <p>
            <a href="index.php#section4" class="btn btn-primary">
                <i class="fa fa-undo" aria-hidden="true"></i> Réessayer    
            </a>
        </p>
    <?php } else { // everything is okay and the user can be created
            $password = hash('sha256', $post_data["password1"] . $post_data["username"]);
            $attraction = toTag($post_data["attraction"]);
            $tags = toTag($post_data["tags"]);
            $registerquery = $G_PDO->prepare("
                INSERT INTO users (username,password,mail,age,gender,attraction,tags,description,photoP,photoA,photoB,photoC,photoD) 
                VALUES(:username,:password,:mail,:age,:gender,:attraction,:tags,:description,:photoP,:photoA,:photoB,:photoC,:photoD)
                ");
            
            $registervalues = array(
                ':username' => $post_data["username"],
                ':password' => $password,
                ':mail' => $post_data["mail"],
                ':age' => $post_data["age"],
                ':gender' => $post_data["gender"],
                ':attraction' => $attraction,
                ':tags' => $tags,
                ':description' => htmlspecialchars($post_data["description"]),
                ':photoP' => "temp",
                ':photoA' => "shadow.jpg",
                ':photoB' => "shadow.jpg",
                ':photoC' => "shadow.jpg",
                ':photoD' => "shadow.jpg"
                );
            if ($registerquery->execute($registervalues)) {?>
                <h1>Inscription réussie !</h1>
                <p>Votre inscription au site Matchat est maintnant terminée.</p>
                <p><a href="index.php#section1" class="btn btn-primary">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Connection    
                </a></p>
                <?php 
                $user = User::find("id", "username", $post_data["username"], $G_PDO);
                $photoname = $user[0]["id"] . "_P.jpg";
                $G_PDO->query("UPDATE users SET photoP = '" . $photoname . "' WHERE id = " . $user[0]["id"]);
                $photo = "medias/photos/" . $user[0]["id"] . "_P.jpg";
                move_uploaded_file($_FILES["datafile"]["tmp_name"], $photo);
                
                // sending confirmation mail...
                $message = 'You are now successfully registered to Matchat!\n\nRemember, your username is ' . $post_data["username"] . '.';
                mail ( $post_data['email'] , 'Welcome to Matchat!' , $message );
                $gender = mysql_getTable("SELECT * FROM gender WHERE value='" . $post_data["gender"] . "'", $G_PDO);
                if (!$gender[0][0]) {
                    $G_PDO->query("INSERT INTO gender (value) VALUES('" . $post_data["gender"] . "')");
                }
                $exp_att = explode(",", $tags);
                foreach ($exp_att as $key => $value) {
                    $attract = mysql_getTable("SELECT * FROM tags WHERE value='" . $value . "'", $G_PDO);
                    if (!$gender[0][0]) {
                        $G_PDO->query("INSERT INTO tags (value) VALUES('" . $value . "')");
                    }
                }
            }
        }
}
?>

<?php include 'includes/footer.php' ?>