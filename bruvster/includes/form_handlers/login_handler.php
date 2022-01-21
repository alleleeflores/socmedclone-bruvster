<?php
    if(isset($_POST['log_btn'])){
        $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //checks if email is in the correct format
        $_SESSION['log_email'] = $email; //stores email into SESSION var

        $password = md5($_POST['log_password']); //gets password

        //looks for email and password in database
        $db_check_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        $login_check_query = mysqli_num_rows($db_check_query);

        if($login_check_query == 1){
            $row = mysqli_fetch_array($db_check_query);
            $username = $row['username'];

            //if email is closed, it reopens account
            $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND user_closed = 'yes'");
            if(mysqli_num_rows($user_closed_query) == 1){
                $reopen_acc = mysqli_query($con, "UPDATE users SET user_closed = 'no' WHERE email = '$email'");
            }

            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        }
        else{
            array_push($error_array, "Email or password entered was incorrect.<br>");
        }
    }
?>