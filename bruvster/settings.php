<?php
    include("includes/header.php");
    include("includes/form_handlers/settings_handler.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Settings| Bruvster</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
    <!-- ADD YOUR CSS -->
    <link rel="stylesheet" href="assets/css/settings.css?v=<?php echo time(); ?>">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Oxygen&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <!------------------------------- MAIN -------------------------------->
    <main>
        <div class="container">

            <?php
                $user_data_query = mysqli_query($con, "SELECT first_name, last_name FROM users WHERE username='$user_logged_in'");
                $row = mysqli_fetch_array($user_data_query);

                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
            ?>

            <!-- LEFT -->
            <div class="left-content">
                <a href="#" class="profile">
                    <div class="profile-pic">
                        <img src="<?php echo $user['profile_pic']; ?>" alt="">
                    </div>
                    <div class="user-info">
                        <h1><?php echo $first_name . " " . $last_name; ?></h1>
                        <p class="text-muted">@<?php echo $user['username']; ?></p>
                    </div>
                </a>

                <a href="includes/handlers/logout.php" class="btn btn-primary">Log Out</a>
            </div>
            <!-- MIDDLE -->
            <div class="middle-content">
                <!-- FEEDS -->
                <div class="feeds">
                    <div class="form-container">
                        <div class="form-content">
                            <!-- ACCOUNT SETTINGS FORM -->
                            <h2 class="form-header">Account Settings</h2>

                            <form action="settings.php" method="POST" class="form">
                                <!-- FIRST_NAME -->
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" placeholder="<?php echo $first_name; ?>">
                                </div>

                                <!-- LAST_NAME -->
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" placeholder="<?php echo $last_name; ?>">
                                </div>

                                <div class="btn-wrapper">
                                    <input type="submit" name="update_details" value="Update Account Details" class="form-btn">
                                </div>
                            </form>

                            <!-- PASSWORD SETTINGS FORM -->
                            <h2 class="form-header password-settings">Password Settings</h2>
                        
                            <form action="settings.php" method="POST" class="form">
                                <!-- OLD PASS -->
                                <div class="form-group">
                                    <label for="old_pass">Old Password</label>
                                    <input type="password" name="old_pass" id="old_pass">
                                </div>

                                <!-- NEW PASS -->
                                <div class="form-group">
                                    <label for="new_pass">New Password</label>
                                    <input type="password" name="new_pass" id="new_pass">
                                </div>

                                <!-- CONFIRM NEW PASS -->
                                <div class="form-group">
                                    <label for="confirm_new">Confirm Password</label>
                                    <input type="password" name="confirm_new" id="confirm_new">
                                </div>

                                <?php echo $password_message; ?>

                                <div class="btn-wrapper">
                                    <input type="submit" name="update_password" value="Change Password" class="form-btn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>