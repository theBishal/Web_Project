<?php

session_start();

$user_id = "";
//check if session "user_id" exist
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    $user_id = $_SESSION["user_id"];
}


if($user_id !== ""){
    $login = true;
}
else {
    $login = false;
    header('Location: ./');
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project</title>
    <link rel="stylesheet" href="./public/styles/main.css" />
</head>
<body>
    <div class="container">
        <div class="header">
        <a href="./"><img src="./public/images/logo.png" width="100" /></a>
            <a href="./contact.php">Contact Us</a>
            <?php if($login == true){ ?>
                <a href="./posts.php">Posts</a>
                <a href="./profile.php" class="active-menu">Profile</a>
                <a href="./logout.php" class="logout">Logout</a>
            <?php } ?>
        </div>
        <?php include './views/profile/index.php'; ?>   
    </div>
</body>
</html>