<?php include 'includes/header.php' ?>

<?php 
// check if the POST datas are not empty.
if (!empty($_POST['password1']) && !empty($_POST['password2']) && $_GET['username'])
{
    $username = $pdo->quote($_GET['username']);
    $password1 = hash('sha256', $username . $pdo->quote($_POST['password1'])); // hash the 
    $password2 = hash('sha256', $username . $pdo->quote($_POST['password2'])); // passwords
    
    if(strcmp($password1, $password2)) // if the two passwords do match
     {
        echo "<h1>Error</h1>";
        echo "<p>Sorry, the passwords you entered do not match.</p>";
        echo '<a class="button" href="index.php">Back to main page</a>' ;
     }elseif(!checkPassword($_POST['password1'])) { // if the password is "secure" enough ?> 
        <h1>Error</h1>
        <p>Your password does not match standard security condition. Check that :</p>
        <ul>
            <li>It is at least 8 characters long</li>
            <li>It contains at least an uppercase letter</li>
            <li>It contains at least a lowercase letter</li>
            <li>It contains at least a number</li>
        </ul>
        <a class="button" href="index.php">Back to main page</a>
     <?php }else
     {
        $query = $pdo->query("UPDATE cmg_users SET password='" . $password1 . "' WHERE username=" . $username);
        echo "<h1>Done !</h1>";
        echo "<p>Your password has been changed.</p>";
        echo '<a class="button" href="index.php">Click here to connect</a>' ;
     }
}
else  // ICE - In case of error
{
    ?>
     
   <h1>Error</h1>
   <p>Sorry, your registration failed. Please go back and try again.</p>  
   <a class="button" href="index.php">Back to main page</a>
     
<?php } ?>

<?php include 'includes/footer.php' ?>