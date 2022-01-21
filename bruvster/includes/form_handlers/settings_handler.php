<?php
    if(isset($_POST['update_details'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $query = mysqli_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name' WHERE username='$user_logged_in'");
    }

    if(isset($_POST['update_password'])){
        $old_pass = strip_tags($_POST['old_pass']);
        $new_pass = strip_tags($_POST['new_pass']);
        $confirm_new = strip_tags($_POST['confirm_new']);

        $password_query = mysqli_query($con, "SELECT password FROM users WHERE username='$user_logged_in'");
        $row = mysqli_fetch_array($password_query);

        $db_password = $row['password'];

        if(md5($old_pass) == $db_password){
            if($new_pass == $confirm_new){
                if(strlen($new_pass) <= 4){
                    $password_message = "Passwords must be at least 5 characters.";
                }
                else{
                    $new_pass_md5 = md5($new_pass);
                    $password_query = mysqli_query($con, "UPDATE users SET password='$new_pass_md5' WHERE username='$user_logged_in'");
                    $password_message = "Passwords has been changed!";
                }
            }else{
                $password_message = "Passwords entered don't match.";
            }
        }
        else{
            $password_message = "The old password is incorrect.";
        }
    }
    else{
        $password_message = "";
    }
?>