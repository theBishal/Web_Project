<?php
require_once (dirname(__DIR__, 2)."/controller/Controller.php");
$ctrlObject = new Controller();

$msg = "";
//forgot password form
if(isset($_POST["Email"])){
    $email = $_POST["Email"];
    
    //check if email address exist
    $msg = $ctrlObject->check_email($email);
    if($msg == "Email address exist"){
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $tokenHex = bin2hex($token);
        $expires=date("U") + 3600;
        //url sent in the email
        $url = "http://bishal711.com.np/?reset-password=1&selector=".$selector."&token=".$tokenHex;
        $result = $ctrlObject->save_token($email, $selector, $tokenHex, $expires);
        //send email
        $subject = "Reset your password";
        $message = "Please click the following link or copy paste in browser to reset your password. If you haven't make this request, you can ignore this email.    ";
        $message .= $url;
        mail($email,$subject,$message);
        //$msg = bin2hex($token);
        $msg = "Please check your inbox, we have send you an email with reset password link.";
        
    }

    header('Location: ./../../?forgot-password=1&msg='.$msg);
}

//reset password form
if(isset($_POST["Newpassword"]) && isset($_POST["Repassword"]) && isset($_POST["selector"]) && isset($_POST["token"])){
    $new_password = $_POST["Newpassword"];
    $selector = $_POST["selector"];
    $token = $_POST["token"];
    if($selector != "" && $token != "" && ctype_xdigit($selector) && ctype_xdigit($token)){
        $msg = $ctrlObject->check_token($selector,$token,$new_password);
    }
    else {
        $msg = "Sorry, we can't validate your request!";
    }
    header('Location: ./../../?msg='.$msg);
}

?>