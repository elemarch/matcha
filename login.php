<?php include 'includes/header.php' ?>

<?php
// This page processes the login.  

if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $post_data = quoteArray($_POST, $G_PDO);
    $password = hash('sha256', $post_data["password"] . $post_data["username"]);
    $query = "SELECT * FROM users WHERE username = '" . $post_data["username"] . "' AND password = '" . $password . "'";
    $checklogin = $G_PDO->query($query);
     
    if($checklogin->rowCount()) {
        $user = new User($post_data["username"], $G_PDO);
        //enter info in session
        $_SESSION['Username'] = $user->getName();
        $_SESSION['EmailAdress'] = $user->getMail();
        $_SESSION['ID'] = $user->getId();
        $_SESSION['LoggedIn'] = 1;
         
        echo "<h1>Success</h1>";
        echo "<p>Click on the menu to navigate through Matchat!</p>";
    }
    else {
        echo "<h1>Error</h1>";
        echo '<p>Wrong password or username.<br>';
        echo '<a class="button" href="index.php">Back to main page</a>' ;
    }
}
?>

<?php include 'includes/footer.php' ?>