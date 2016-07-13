<?php
  session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/blog-home.css">
    <link rel="stylesheet" href="css/light-theme.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

</head>



<body id="app-layout">
<nav class="navbar navbar-akash navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="home.php">
                <img class="nav-img" src="images/logo.png" alt="" height="50px" width="150px;">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

                <li class=" "><a href="find.php">Find Relatives</a></li>
                <li class=" "><a href="tree.php">Generations Tree</a></li>
                <li class=" "><a href="profile.php"><?php echo $_SESSION['name']; ?> </a></li>
                <li class=" "><a href="index.php">Logout</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="container" align="center">
    <div class="row" align="center" style="text-align: justify">
        
      <!--     -->