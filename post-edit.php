<?php
//ini_set('display_errors', 1);
require_once (__DIR__."/controller/Controller.php");
$ctrlObject = new Controller();
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

//if there is ?post_id in the url
$post_id = 0;
$post = null;

if(isset($_GET["post_id"])){
    $post_id = $_GET["post_id"];
    $post = $ctrlObject->get_post($post_id, $user_id);
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
        <?php 
        if($login == true && $post !== null){ ?>
            <form id="edit_post" action="posts.php" method="post">
                <h3>Edit your post</h3>
                <input type="hidden" name="post_id" value="<?php echo($post_id) ?>" />
                <textarea name="Edit_Post" placeholder="Edit your post"><?php echo($post) ?></textarea>
                <input type="submit" value="Save the edit" /> <a href="posts.php">Cancel</a>
            </form>
        <?php }
        else {
            echo("<p>Sorry, you can't edit this post.</p><a href='posts.php'>Go back to posts</a>");
        }  
        ?>   
    </div>
</body>
</html>