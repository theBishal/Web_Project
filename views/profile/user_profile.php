<?php
require_once (__DIR__."/../../controller/Controller.php");
$ctrlObject = new Controller();

$user_id = $_SESSION["user_id"];
$result = $ctrlObject->get_profile($user_id);

$user_name = $result[0]["name"];
$user_email = $result[0]["email"];

$target_dir = "public/images/";
$user_photo = "";
if($result[0]["photo"] !== ""){
    $user_photo = $result[0]["photo"];
}
else {
    $user_photo = "default_profile_img.png";
}

//if there is ?edit in the url
$edit = 0;
if(isset($_GET["edit"])){
    $edit = $_GET["edit"];
}

//if there is ?edit in the url
$change_pwd = 0;
if(isset($_GET["change-password"])){
    $change_pwd = $_GET["change-password"];
}

//if form submit with method="post", edit profile form submit
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Name"]) && isset($_POST["Email"])){
    $name = $_POST["Name"];
    $email = $_POST["Email"];

    // if file size is not equals to 0, meaning if some file is selected  
    if($_FILES['Photo']['size'] !== 0) {
        $target_dir = "public/images/";
        $temp_file = $_FILES["Photo"]["tmp_name"];
        $target_file = $target_dir . basename($_FILES["Photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $file_name = $user_id.".".$imageFileType;
        move_uploaded_file($temp_file, $target_dir.$file_name);
    }
    //if no file is selected, use the old file name and don't upload anything in the folder
    else {
        $file_name = $user_photo;
    }
    $ctrlObject->edit_user($user_id, $name, $email, $file_name);
    $result = $ctrlObject->get_profile($user_id);

    $user_name = $result[0]["name"];
    $user_email = $result[0]["email"];
    if($result[0]["photo"] !== ""){
        $user_photo = $result[0]["photo"];
    }
    else {
        $user_photo = "default_profile_img.png";
    }

}

$new_password_msg = "";
//if form submit with method="post", edit profile form submit
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Oldpassword"]) && isset($_POST["Newpassword"])){
    $old_password = $_POST["Oldpassword"];
    $new_password = $_POST["Newpassword"];
    $new_password_msg = $ctrlObject->change_password($user_id, $old_password, $new_password);
    if($new_password_msg == "Password update success!"){
        $change_pwd = 0;
    }
    else{
        $change_pwd = 1;
    }
    
}

?>

<div class="profile-img-background">
    <img src="<?php echo($target_dir.$user_photo) ?>" class="profile-img" />
</div>
<div class="message"><?php echo($new_password_msg) ?></div>
<?php if ($edit == 1){ ?>
<form action="profile.php" method="post" enctype="multipart/form-data">
    <div><label>Name: </label><input type="text" name="Name" value="<?php echo($user_name) ?>" required /></div>
    <div><label>Email: </label><input type="email" name="Email" value="<?php echo($user_email) ?>" required /></div>
    <div><label>Photo: </label><input type="file" name="Photo" id="Photo" value="" accept="image/*" /></div>
    <div>
        <input type="submit" value="Save Changes" /> <input type="button" value="Cancel" onClick="cancel()" />
    </div>
</form>
<?php } else if ($change_pwd == 1) { ?>
<form action="profile.php" method="post">
    <div><label>Old Password: </label><input type="password" name="Oldpassword" value="" required /></div>
    <div><label>New Password: </label><input type="password" name="Newpassword" value="" required /></div>
    <div>
        <input type="submit" value="Save Changes" /> <input type="button" value="Cancel" onClick="cancel()" />
    </div>
</form>
<?php } else { ?>
<div class="profile-info">
    <div class="edit">
        <a href="profile.php?edit=1">✏️ Edit Profile</a>
        <a href="profile.php?change-password=1">🔑 Change Password</a>
    </div>
    <div><label>Name: </label><span><?php echo($user_name) ?></span></div>
    <div><label>Email: </label><span><?php echo($user_email) ?></span></div>
    
</div>
<?php } ?>

<script>
    function cancel (){
        window.location = "profile.php";
    }
</script>