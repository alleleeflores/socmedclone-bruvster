<?php
    require 'config/config.php';

    //contains the username of the user logged in
    if (isset($_SESSION['username'])){
        $user_logged_in = $_SESSION['username'];
        //returns information of the user as an array
        $user_info_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_logged_in'");
        $user = mysqli_fetch_array($user_info_query);
    }
    else{
        //loads user in main page and stops access to home page
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Bruvster</title>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
    <!-- ADD YOUR CSS -->
    <link rel="stylesheet" href="assets/css/home.css?v=<?php echo time(); ?>">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Oxygen&family=Roboto&display=swap" rel="stylesheet">

    <!-- FOR LIKES AND COMMENTS -->
    <script>
        $(document).ready(function(){
            $(".cmntBtn").click(function(){
                var id = $(this).data("id");
                var name = ".feed-comments-" + id;
                console.log(id + " " +name);
                $(name).toggle();
            });

            $(".likeBtn").click(function(){
                var id = $(this).data("id");
                $(this).find("i").toggleClass("bi bi-emoji-sunglasses");
                $(this).find("small").text(function(i, text){
                    return text === "1" ? "0" : "1";
                })
            });
        });
    </script>
</head>
<body>
    <!------------------------------- NAVIGATION -------------------------------->
    <nav>
        <div class="container">
            <a href="home.php" class="logo">
                <img src="assets/img/logo/bruvster-logo-lights.png" alt="Bruvster" id="logo">
            </a>
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="search" placeholder="Search">
            </div>
            <div class="create">
                <label class="btn btn-primary" for="create-post">Create</label>
                <div class="profile-pic">
                    <a href="#">
                        <img src="<?php echo $user['profile_pic']; ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
    </nav>