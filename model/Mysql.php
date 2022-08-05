<?php
include 'db.php';

class Mysql
{
    //authenticate user during login and return number of row $rowcount, and id of the logged in user $rows, as an array.
    public function auth_user ($email, $password){
        $sql = "SELECT id, password FROM users WHERE email='$email'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            $rowcount = mysqli_num_rows($result);
            if(password_verify($password, $rows[0]['password'])){
                return array($rowcount, $rows);
            }
            else {
                return array(0, []);    
            }
        }
        else {
            return array(0, []);
        }
    }

    //get user data from database
    public function read_user ($id) {
        $sql = "SELECT id, name, email, photo FROM users WHERE id='$id'";
        global $conn;
        $result = mysqli_query($conn, $sql);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return $rows;
    }

    //create new user in database and return new insert_id if successful
    public function create_user ($name, $email, $password){
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, photo) VALUES ('$name', '$email', '$hash_password', '')";
        global $conn;
        if ($result = mysqli_query($conn, $sql)){
            return $conn->insert_id;
        }
        else{
            return null;
        }
        
    }

    //update existing user
    public function update_user ($id, $name, $email, $photo){
        $sql = "UPDATE users SET name = '$name', email = '$email', photo = '$photo' WHERE id='$id'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            return $result;
        }
        else {
            return null;
        }
    }

    //read all posts
    public function read_posts(){
        $sql = "SELECT posts.id, posts.user_id, users.name, users.photo, posts.post FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
        global $conn;
        $result = mysqli_query($conn, $sql);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return $rows;
    }

    //read one post
    public function read_post($post_id, $user_id){
        $sql = "SELECT post from posts where id = '$post_id' AND user_id = '$user_id'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            return $rows;
        }
        else {
            return null;
        }
    }

    //insert new post
    public function create_post($user_id, $post){
        $sql = "INSERT INTO posts (user_id, post) VALUES ('$user_id', '$post')";
        global $conn;
        $result = mysqli_query($conn, $sql);
    }

    //update post
    public function update_post($post_id, $user_id, $post){
        $sql = "UPDATE posts SET post = '$post' WHERE id = '$post_id' AND user_id = '$user_id'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            return $result;
        }
        else {
            return null;
        }
    }

    //delete post
    public function delete_post($post_id, $user_id){
        $sql = "DELETE FROM posts WHERE id='$post_id' AND user_id='$user_id'";
        global $conn;
        $result = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) > 0){
            return "Delete Success!";
        }
        else {
            return "Sorry, can't delete!";
        }
        
    }

    //update password
    public function update_password($user_id, $old_password, $new_password){
        $sql = "SELECT password FROM users WHERE id='$user_id'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            $rowcount = mysqli_num_rows($result);
            if(password_verify($old_password, $rows[0]['password'])){
                $new_hash_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql2 = "UPDATE users SET password = '$new_hash_password' WHERE id='$user_id'";
                if(mysqli_query($conn, $sql2)){
                    return "Password update success!"; 
                }
                else{
                    return "Sorry, something went wrong!";
                }
                
            }
            else {
                return "Sorry, Old password doesn't match!";    
            }
        }
    }

    //check email exist
    public function check_email($email){
        $sql = "SELECT id from users WHERE email='$email'";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
                return "Email address exist";
            }
            else{
                return "Sorry, we can't find this email address in our system.";    
            }
        }
        else {
            return "Sorry, something went wrong!";
        }
    }

    //create new token entry
    public function create_token_entry($email, $selector, $token, $expires){
        $sql = "INSERT INTO pwd_reset (email, selector, token, expires) VALUES ('$email', '$selector', '$token', '$expires')";
        global $conn;
        if ($result = mysqli_query($conn, $sql)){
            return $conn->insert_id;
        }
        else{
            return null;
        }
    }

    //check token and reset password
    public function check_token_reset_password($selector, $token, $new_password){
        $current_date = date("U");
        $sql = "SELECT id, email, token FROM pwd_reset WHERE selector='$selector' AND token='$token' AND expires>='$current_date' ORDER BY id DESC";
        global $conn;
        if($result = mysqli_query($conn, $sql)){
            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            $rowcount = mysqli_num_rows($result);
            if($rowcount > 0){
                $user_email = $rows[0]['email'];
                $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql2 = "UPDATE users SET password = '$hash_password' WHERE email='$user_email'";
                if($result = mysqli_query($conn, $sql2)){
                    $sql3 = "DELETE FROM pwd_reset WHERE email='$user_email'";
                    mysqli_query($conn, $sql3);
                    return "New Password reset successfully.";
                }
                else {
                    return "Sorry, something went wrong!";
                }
            }
            else{
                return "You need to re-submit your reset request.";    
            }
        }
        else {
            return "You need to re-submit your reset request.";
        }
    }
}
?>