<?php
    require 'config/config.php';
    require 'includes/form_handlers/register_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruvster | Sign Up</title>
    <!-- Forces Css to reload -->
    <link rel="stylesheet" type="text/css" href="assets/css/register.css?v=<?php echo time(); ?>">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Oxygen&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<section class="form-main-page">
        <div class="form-left">
            <a href="index.php">
                <img src="assets/img/logo/bruvster-logo-lights.png" alt="Bruvster">
            </a>
        </div>
        <div class="form-right">
            <div class="form-container">
                <div class="form-content">
                    <h2 class="form-header">Create your account</h2>

                    <!-- REGISTER FORM -->
                    <form action="register.php" method="POST" class="form">
                        <!-- FIRST NAME -->
                        <div class="form-group">
                            <label for="reg_fname">First Name</label>
                            <input type="text" name="reg_fname" id="reg_fname" placeholder="First Name" value="<?php 
                                if(isset($_SESSION['reg_fname'])){
                                    echo $_SESSION['reg_fname'];
                            } ?>" required>

                            <?php if(in_array("Your first name must be between 2 and 25 characters.<br>", $error_array)) echo"Your first name must be between 2 and 25 characters.<br>"; ?>
                        </div>

                        <!-- LAST NAME -->
                        <div class="form-group">
                            <label for="reg_lname">Last Name</label>
                            <input type="text" name="reg_lname" id="reg_lname" placeholder="Last Name" value="<?php 
                                if(isset($_SESSION['reg_lname'])){
                                    echo $_SESSION['reg_lname'];
                            } ?>" required>

                            <?php if(in_array("Your last name must be between 2 and 25 characters.<br>", $error_array)) echo"Your last name must be between 2 and 25 characters.<br>"; ?>
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">
                            <label for="reg_email">Email</label>
                            <input type="email" name="reg_email" id="reg_email" placeholder="Email" value="
                            <?php 
                                if(isset($_SESSION['reg_email'])){
                                    echo $_SESSION['reg_email'];
                            } ?>" required>

                            <?php if(in_array("Email is already in use.<br>", $error_array)) echo"Email is already in use.<br>";
                            else if(in_array("Invalid email format.<br>", $error_array)) echo"Invalid email format.<br>"; ?>
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">
                            <label for="reg_password">Password</label>
                            <input type="password" name="reg_password" id="reg_password" placeholder="Password" required>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="form-group">
                            <label for="reg_confirm">Confirm Password</label>
                            <input type="password" name="reg_confirm" id="reg_confirm" placeholder="Confirm Password" required>

                            <?php if(in_array("Your passwords do not match.<br>", $error_array)) echo"Your passwords do not match.<br>";
                            else if(in_array("Your password can only contain English alphanumeric characters.<br>", $error_array)) echo"Your password can only contain English alphanumeric characters.<br>";
                            else if(in_array("Your password must be between 5 and 30 characters.<br>", $error_array)) echo"Your password must be between 5 and 30 characters.<br>"; ?>
                        </div>

                        <div class="btn-wrapper">
                            <input type="submit" name="reg_btn" value="Sign Up"> <!-- class="form-btn -->
                        </div>
                    </form>
                    <footer class="form-footer">
                        <p>Already have an account? <a href="login.php">Log in now</a></p>
                    </footer>
                </div>
            </div>
        </div>
    </section>
</body>
</html>