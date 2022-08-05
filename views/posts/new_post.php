<?php
require_once (__DIR__."/../../controller/Controller.php");
$ctrlObject = new Controller();

$user_id = $_SESSION["user_id"];
$result = $ctrlObject->get_profile($user_id);

$user_name = $result[0]["name"];

if(isset($_POST["New_Post"])){
    $ctrlObject->new_post($user_id, $_POST["New_Post"]);
    //header('Location: ./posts.php');
}

?><form id="new_post" action="#" method="post">
    <textarea name="New_Post" placeholder="What is on your mind, <?php echo($user_name) ?>?"></textarea>
    <input type="submit" value="Post"> <input type="button" value="Clear" onClick="clearPost()" />
</form>

<script>
    function clearPost (){
        document.getElementById("new_post").reset();
    }
</script>