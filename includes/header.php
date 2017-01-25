<?php
include 'config/database.php';
include 'config/connect.php';
include 'functions/functions.php';
include 'config/session.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Matcha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:300,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:900" rel="stylesheet">
    <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.bootstrap2.min.css">

    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" media="screen and (max-width: 800px)" href="styles/small.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'right'
    });
});
</script>
</head>
<?php if (isset($G_USER) && $G_USER->isConnected()) { 
// MENU FOR THE CONNECTED
    ?>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="medias/src/cat.png">Matchat</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><i class="fa fa-question fa-fw" aria-hidden="true"></i> Suggestions</a></li>
                        <li><a href="#"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> Visiteurs</a></li> 
                        <li><a href="#"><i class="fa fa-history fa-fw" aria-hidden="true"></i> Historique</a></li> 
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><i class="fa fa-bell fa-fw" aria-hidden="true"></i> Notifications <?php echo "<span class=\"badge\">5</span>"//$user->getName() ?></a></li>
                            <li><a href="#"><i class="fa fa-user fa-fw" aria-hidden="true"></i> <?php echo $G_USER->getName() ?></a></li>
                            <li><a href="logout.php"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </ul>
                </div>
            </div>
        </nav>
        <?php } else { ?>
        <body data-spy="scroll" data-target=".navbar" data-offset="50">

            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span> 
                        </button>
                        <a class="navbar-brand" href="index.php"><img src="medias/src/cat.png">Matchat</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php#section1">Se connecter</a></li>
                            <li><a href="index.php#section2">Des suggestions à votre mesure</a></li>
                            <li><a href="index.php#section3">Ils sont sur le site !</a></li>
                            <li><a href="index.php#section4">Nous rejoindre</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <?php } ?>
        <div class="content">