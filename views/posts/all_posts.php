<?php
require_once (__DIR__."/../../controller/Controller.php");
$ctrlObject = new Controller();

//check if session "user_id" exist
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    $user_id = $_SESSION["user_id"];
}

$posts = $ctrlObject->all_posts();
$target_dir = "public/images/";
//on delete
if(isset($_GET["delete_id"])){
    $post_id = $_GET["delete_id"];
    $delete = $ctrlObject->delete_post($post_id, $user_id);
    $posts = $ctrlObject->all_posts();
    //header('Location: ./posts.php');
    //echo($delete);
}
?>

<?php foreach($posts as $post){ 
    if($post["photo"] !== ""){
        $user_photo = $post["photo"];
    }
    else {
        $user_photo = "default_profile_img.png";
    }
    
?>
<div class="post">
    <div class="img-name">
        <div>
            <img src="<?php echo($target_dir.$user_photo) ?>" class="post-profile-img" />
            <?php 
            if($post["user_id"] == $user_id){ 
                echo($post["name"]." (You)"); 
            } 
            else { 
                echo($post["name"]); 
            } ?>
        </div>
        <?php if($post["user_id"] == $user_id){ ?>
            <span style="float: right;"><a href="post-edit.php?post_id=<?php echo($post['id']) ?>" style="color: red; text-decoration: none; font-size: 14px;" title="edit">✏️</a> | <a href="posts.php?delete_id=<?php echo($post['id']) ?>" style="color: red; text-decoration: none; font-size: 18px;" title="delete" onclick="return confirm('Are you sure you want to delete this item')">🗑</a></span>
        <?php } ?>
    </div>
    <div class="post-text"><?php echo($post["post"]) ?></div>
</div>
<?php } ?>