<?php
    require 'config/config.php';
    require 'includes/form_handlers/register_handler.php';
    require 'includes/form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruvster | Log In</title>
    <!-- Forces Css to reload -->
    <link rel="stylesheet" type="text/css" href="assets/css/login.css?v=<?php echo time(); ?>">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Oxygen&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<section class="form-main-page">
        <div class="form-left">
            <div class="form-container">
                <div class="form-content">
                    <h2 class="form-header">What's poggin?</h2>
                    
                    <!-- LOGIN FORM -->
                    <form action="#" method="POST" class="form">
                        <!-- Username or Email -->
                        <div class="form-group">
                            <label for="log_email">Email</label>
                            <input type="text" name="log_email" id="log_email" placeholder="Email" value="<?php 
                                if(isset($_SESSION['log_email'])){
                                    echo $_SESSION['log_email'];
                            } ?>" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="log_password">Password</label>
                            <input type="password" name="log_password" id="log_password" placeholder="Password" required>
                            <?php if(in_array("Email or password entered was incorrect.<br>", $error_array)) echo"Email or password entered was incorrect.<br>"; ?>
                        </div>

                        <div class="btn-wrapper">
                            <input type="submit" name="log_btn" value="Log In" class="form-btn">
                        </div>
                    </form>
                    <footer class="form-footer">
                        <p>Still not a bruv? <a href="register.php">Be a bruv now!</a></p>
                    </footer>
                </div>
            </div>
        </div>
        <div class="form-right">
            <a href="index.php">
                <img src="assets/img/logo/bruvster-logo-lights.png" alt="Bruvster">
            </a>
        </div>
    </section>
</body>
</html>