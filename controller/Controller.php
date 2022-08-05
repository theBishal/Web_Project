<?php
include_once (__DIR__."../../model/Mysql.php");


class Controller
{
    //check login data
    public function check_login ($email, $password)
    {
        $mysqlObject = new Mysql();        
        $result = $mysqlObject->auth_user($email,$password);
        if($result[0] >= 1){
            foreach($result[1] as $row){
                $_SESSION["user_id"] = $row["id"];
            }
            return true;
        }
        else {
            return false;
        }
    }
    
    //logout, unset or remove session data
    public function logout ()
    {
        unset($_SESSION["user_id"]);
    }

    //get user profile
    public function get_profile ($id)
    {
        $mysqlObject = new Mysql();
        $result = $mysqlObject->read_user($id);
        return $result;  
    }

    //register new user
    public function register_user ($name, $email, $password) {
        $mysqlObject = new Mysql();
        $result = $mysqlObject->create_user($name, $email, $password);
        if($result !== null){
            $_SESSION["user_id"] = $result;
            return true;
        }
        else {
            return false;
        }
    }

    //edit user
    public function edit_user ($id, $name, $email, $photo){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->update_user($id, $name, $email, $photo);
        if($result !== null) {
            return true;
        }
        else {
            return false;
        }
    }

    //get all posts
    public function all_posts() {
        $mysqlObject = new Mysql();
        $result = $mysqlObject->read_posts();
        return $result;
    }

    //add new post
    public function new_post($user_id, $post){
        $mysqlObject = new Mysql();
        $mysqlObject->create_post($user_id, $post);
    }

    //get one post to edit
    public function get_post($post_id, $user_id){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->read_post($post_id, $user_id);
        if($result !== null){
            return $result[0]['post'];
        }
        else {
            return $result;
        }
        
    }

    //edit post
    public function edit_post($post_id, $user_id, $post){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->update_post($post_id, $user_id, $post);
        return $result;
    }

    //delete existing post
    public function delete_post($post_id, $user_id){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->delete_post($post_id, $user_id);
        return $result;
    }

    //change password
    public function change_password($user_id, $old_password, $new_password){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->update_password($user_id, $old_password, $new_password);
        return $result;
    }

    //check email exist
    public function check_email($email){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->check_email($email);
        return $result;
    }

    //save token
    public function save_token($email, $selector, $token, $expires){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->create_token_entry($email, $selector, $token, $expires);
        return $result;
    }

    //check token
    public function check_token($selector, $token, $new_password){
        $mysqlObject = new Mysql();
        $result = $mysqlObject->check_token_reset_password($selector, $token, $new_password);
        return $result;
    }
}