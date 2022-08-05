<?php
$msg = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if(isset($email) && isset($message)){
        mail('bishalshrestha133@gmail.com',$name,$message,$email);
        $msg = "Thanks! we just receive your message.";
    }
    else{
        $msg = "Sorry! we can't read your message.";
    }
}
// header('Location: /');
?>
<div class="wrapper">
    <div class="message"><?php echo($msg) ?></div>
    <div class="contact_us">
        <form action="#" id="contact" method="post">
            <h3>GET IN TOUCH</h3>
            <input type="text" id="name" name="name" placeholder="Your Name" required>
            <input type="email" id="email" name="email" placeholder="Your Email" required>
            <textarea id="message" name="message" rows="4" placeholder="How can I help you?"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>    
</div>
