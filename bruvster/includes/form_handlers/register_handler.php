<?php
    //declaring variables to prevent errors
    $fname = ""; //first name
    $lname = ""; //last name
    $email = ""; //email
    $password = ""; //password
    $confirm = ""; //confirm pass
    $date = ""; //sign up date
    $error_array = array(); //holds error messages

    if(isset($_POST['reg_btn'])){
        //Registration form values
        
        //FIRST NAME
        $fname = strip_tags($_POST['reg_fname']); //gets rid of html tags
        $fname = str_replace(' ','', $fname); //replaces spaces
        $fname = ucfirst(strtolower($fname)); //converts all characters to lowercase and converts first letter to uppercase
        $_SESSION['reg_fname'] = $fname; //stores fname into session var

        //LAST NAME
        $lname = strip_tags($_POST['reg_lname']); //gets rid of html tags
        $lname = str_replace(' ','', $lname); //replaces spaces
        $lname = ucfirst(strtolower($lname)); //converts all characters to lowercase and converts first letter to uppercase
        $_SESSION['reg_lname'] = $lname; //stores lname into session var

        //EMAIL
        $email = strip_tags($_POST['reg_email']); //gets rid of html tags
        $email = str_replace(' ','', $email); //replaces spaces
        $_SESSION['reg_email'] = $email; //stores email into session var

        //PASSWORD
        $password = strip_tags($_POST['reg_password']); //gets rid of html tags
        
        //CONFIRM PASSWORD
        $confirm = strip_tags($_POST['reg_confirm']); //gets rid of html tags

        $date = date("Y-m-d"); //gets current date

        //checks if email is in valid format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            //checks if email already exists
            $em_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

            //counts number of rows returned
            $num_rows = mysqli_num_rows($em_check);

            if($num_rows > 0){
                array_push($error_array, "Email is already in use.<br>");
            }
        }
        else{
            array_push($error_array, "Invalid email format.<br>"); //
        }

        //checks length of first name
        if(strlen($fname) > 25 || strlen($fname) < 2){
            array_push($error_array, "Your first name must be between 2 and 25 characters.<br>");
        }

        //checks length of last name
        if(strlen($lname) > 25 || strlen($lname) < 2){
            array_push($error_array, "Your last name must be between 2 and 25 characters.<br>");
        }

        //checks if passwords match and if it conatins alphanumeric characters
        if($password != $confirm){
            array_push($error_array, "Your passwords do not match.<br>");
        }
        else{
            if(preg_match('/[^A-Za-z0-9]/', $password)){
                array_push($error_array, "Your password can only contain English alphanumeric characters.<br>");
            }
        }

        //checks if password is between 5 to 30 characters
        if (strlen($password) > 30 || strlen($password) < 5){
            array_push($error_array, "Your password must be between 5 and 30 characters.<br>");
        }

        //handles inserting values into the database
        if(empty($error_array)){
            $password = md5($password); //encrypts and hides password to a long string

            //Generate username by concatenating first name and last name
            $username = strtolower($fname . "_" . $lname);

            //checks if username already exists
            $un_check_query = mysqli_query($con, "SELECT username FROM users WHERE username ='$username'");

            $i = 0;

            //if username exists, add number to username
            while(mysqli_num_rows($un_check_query) != 0){
                $i++;
                $username = $username . "_" . $i;
                $un_check_query = mysqli_query($con, "SELECT username FROM users WHERE username ='$username'");
            }

            //assigns a randomized default prof pic
            $rand = rand(1, 21); //random number between 1 and 21
            
            if($rand == 1){
                $profile_pic = "assets/img/profile_pics/defaults/black_def_pic.jpg";
            }
            else if ($rand == 2){
                $profile_pic = "assets/img/profile_pics/defaults/bonk_def_pic.jpg";
            }
            else if ($rand == 3){
                $profile_pic = "assets/img/profile_pics/defaults/cap_def_pic.jpg";
            }
            else if ($rand == 4){
                $profile_pic = "assets/img/profile_pics/defaults/catmaid_def_pic.jpg";
            }
            else if ($rand == 5){
                $profile_pic = "assets/img/profile_pics/defaults/corona_def_pic.jpg";
            }
            else if ($rand == 6){
                $profile_pic = "assets/img/profile_pics/defaults/darkblue_def_pic.jpg";
            }
            else if ($rand == 7){
                $profile_pic = "assets/img/profile_pics/defaults/darkbrown_def_pic.jpg";
            }
            else if ($rand == 8){
                $profile_pic = "assets/img/profile_pics/defaults/darkpink_def_pic.jpg";
            }
            else if ($rand == 9){
                $profile_pic = "assets/img/profile_pics/defaults/gojo_def_pic.jpg";
            }
            else if ($rand == 10){
                $profile_pic = "assets/img/profile_pics/defaults/green_def_pic.jpg";
            }
            else if ($rand == 11){
                $profile_pic = "assets/img/profile_pics/defaults/high_def_pic.jpg";
            }
            else if ($rand == 12){
                $profile_pic = "assets/img/profile_pics/defaults/levi_def_pic.jpg";
            }
            else if ($rand == 13){
                $profile_pic = "assets/img/profile_pics/defaults/lightbrown_def_pic.jpg";
            }
            else if ($rand == 14){
                $profile_pic = "assets/img/profile_pics/defaults/lightpink_def_pic.jpg";
            }
            else if ($rand == 15){
                $profile_pic = "assets/img/profile_pics/defaults/mikasa_def_pic.jpg";
            }
            else if ($rand == 16){
                $profile_pic = "assets/img/profile_pics/defaults/monster_def_pic.jpg";
            }
            else if ($rand == 17){
                $profile_pic = "assets/img/profile_pics/defaults/purple_def_pic.jpg";
            }
            else if ($rand == 18){
                $profile_pic = "assets/img/profile_pics/defaults/red_def_pic.jpg";
            }
            else if ($rand == 19){
                $profile_pic = "assets/img/profile_pics/defaults/rich_def_pic.jpg";
            }
            else if ($rand == 20){
                $profile_pic = "assets/img/profile_pics/defaults/tan_def_pic.jpg";
            }
            else if ($rand == 21){
                $profile_pic = "assets/img/profile_pics/defaults/yellow_def_pic.jpg";
            }
        
            $query = "INSERT INTO users VALUES (NULL, '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')";

            if (mysqli_query($con, $query)){

                echo "User saved in the database successfully!";
                header("Location: login.php");
                exit();
            }
            else{
                echo "Error: " . mysqli_error($con);
            }

            //Clear SESSION var
            $_SESSION['reg_fname'] = "";
            $_SESSION['reg_lname'] = "";
            $_SESSION['reg_email'] = "";
        }
    }
?>