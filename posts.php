<?php
//ini_set('display_errors', 1);
require_once (__DIR__."/controller/Controller.php");
$ctrlObject = new Controller();
session_start();

$user_id = "";
$login_message = "";
//check if session "user_id" exist
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    $user_id = $_SESSION["user_id"];
}


if($user_id !== ""){
    $login = true;
}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Email"]) && isset($_POST["Password"])){
    $name = "";
    $email = $_POST["Email"];
    $password = $_POST["Password"];

    //if the form contains Name, that means it is registration form
    if(isset($_POST["Name"])){
        $name = $_POST["Name"];
    }

    //if $name is not empty, register as a new user. Else login
    if($name !== ""){
        $login = $ctrlObject->register_user($name, $email, $password);    
    }
    else {
        $login = $ctrlObject->check_login($email, $password);
        
    }
    
    //if login or register fails
    if($login == false){
        $login_message = "Email or password doesn't match, Please try again!";
    }
}
else {
    $login = false;
    header('Location: ./');
}

//if the post edit form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Edit_Post"])){
    $post_id = $_POST["post_id"];
    $post = $_POST["Edit_Post"];
    $ctrlObject->edit_post($post_id, $user_id, $post);
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
                <a href="./posts.php" class="active-menu">Posts</a>
                <a href="./profile.php">Profile</a>
                <a href="./logout.php" class="logout">Logout</a>
            <?php } ?>
        </div>
        <div class="message"><?php echo($login_message) ?></div>
        <?php 
        if($login == true){
            include './views/posts/index.php';
        }
        else {
            include './views/form/register_login.php';
        }  
        ?>   
    </div>
</body>
</html>