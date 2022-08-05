<?php
$msg=""; 
$forgot_password = 0;
if(isset($_GET["forgot-password"])){
   $forgot_password = $_GET["forgot-password"];
}

$reset_password = 0;
if(isset($_GET["reset-password"])){
   $reset_password = $_GET["reset-password"];
}

//msg
if(isset($_GET["msg"])){
   $msg = $_GET["msg"];
}
?>
<div class="wrapper register_login">
   <?php if($forgot_password == "1"){ ?>
      <div class="title-text">
         <div class="title">
            Forgot Password?
         </div>
      </div>
      <div class="form-container">
         <div class="form-inner">
            <form action="./views/form/password_reset.php" method="post" class="">
               <div class="field">
                  <input type="email" placeholder="Email" name="Email" required>
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Send a Reset password link">
               </div>
               <div class="register-link">
                  <a href="./">Login now</a>
               </div>
            </form>
         </div>
      </div>
   <?php } else if($reset_password == 1) { ?>
      <div class="title-text">
         <div class="title">
            Reset your password
         </div>
      </div>
      <div class="form-container">
         <div class="form-inner">
            <form action="./views/form/password_reset.php" method="post" class="" onsubmit="return pass()">
               <input type="hidden" name="selector" value="<?php echo($_GET["selector"]) ?>" />
               <input type="hidden" name="token" value="<?php echo($_GET["token"]) ?>" />
               <div class="field">
                  <input type="password" placeholder="New Password" id="NewPass" name="Newpassword" required >
                  <span id="msg"></span>
               </div>
               <div class="field">
                  <input type="password" placeholder="Retype New Password" id="RePass" name="Repassword" required>
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Reset your password">
               </div>
               <div class="register-link">
                  <a href="./">Login now</a>
               </div>
            </form>
         </div>
      </div>
   <?php } else { ?>
   <div class="title-text">
      <div class="title login">
         Already Member?
      </div>
      <div class="title register">
         New Member?
      </div>
   </div>
   <div class="form-container">
      <div class="slide-controls">
         <input type="radio" name="slide" id="login" checked>
         <input type="radio" name="slide" id="register">
         <label for="login" class="slide login">Login</label>
         <label for="register" class="slide register">Register</label>
         <div class="slider-tab"></div>
      </div>
      <div class="form-inner">
         <!-- Login Form -->
         <form action="posts.php" method="post" class="login">
            <div class="field">
               <input type="email" placeholder="Email" name="Email" required>
            </div>
            <div class="field">
               <input type="password" placeholder="Password" name="Password" required>
            </div>
            <div class="pass-link">
               <a href="./?forgot-password=1">Forgot password?</a>
            </div>
            <div class="field btn">
               <div class="btn-layer"></div>
               <input type="submit" value="Login">
            </div>
            <div class="register-link">
               Not a member? <a href="">Register now</a>
            </div>
         </form>
         <!-- Register Form -->
         <form action="posts.php" method="post" class="register" onsubmit="return passCheck()">
            <div class="field">
               <input type="text" placeholder="Name" name="Name" required>
            </div>
            <div class="field">
               <input type="email" placeholder="Email" name="Email" required>
            </div>
            <div class="field">
               <input type="password" placeholder="Password" name="Password" id="Password" required value="">
               <span id="message" style="color: red;"></span>
            </div>
            <div class="field">
               <input type="password" placeholder="Confirm password" name="Re-Password" id="Re-Password" required value="">
            </div>
            <div class="field btn">
               <div class="btn-layer"></div>
               <input type="submit" value="Register">
            </div>
         </form>
      </div>
   </div>
   <?php } ?>
   <div class="message"><?php echo($msg) ?></div>
</div>
<script>
   const loginText = document.querySelector(".title-text .login");
   const loginForm = document.querySelector("form.login");
   const loginBtn = document.querySelector("label.login");
   const registerBtn = document.querySelector("label.register");
   const registerLink = document.querySelector("form .register-link a");
   registerBtn.onclick = (() => {
      loginForm.style.marginLeft = "-50%";
      loginText.style.marginLeft = "-50%";
   });
   loginBtn.onclick = (() => {
      loginForm.style.marginLeft = "0%";
      loginText.style.marginLeft = "0%";
   });
   registerLink.onclick = (() => {
      registerBtn.click();
      return false;
   });

   function passCheck() {
      let password = document.getElementById("Password").value;
      let confirmPassword = document.getElementById("Re-Password").value;

      if (password != confirmPassword) 
      {
         document.getElementById("message").innerHTML = "Passwords do not match!";
         return false;
      } else if (password == confirmPassword) {
         document.getElementById("message").innerHTML = "";
         return true;
      }

   }
   
     function pass()
      {
         let pass = document.getElementById("NewPass").value;
         let repass = document.getElementById("RePass").value;

         if(pass != repass)
         {
            document.getElementById("msg").innerHTML = "Passwords do not match!";
            return false;
         }
         else if(pass == repass)
         {
            document.getElementById("msg").innerHTML = "";
            return true;
         }
      }
</script>
