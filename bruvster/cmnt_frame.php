<?php
    require 'config/config.php';
    include("includes/classes/User.php");
    include("includes/classes/Posts.php");

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
    <title></title>
    <!-- ADD YOUR CSS -->
    <link rel="stylesheet" href="assets/css/home.css?v=<?php echo time(); ?>">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Oxygen&family=Roboto&display=swap" rel="stylesheet">

    <style>
        body {
        background-color: transparent;
        }
    </style>

</head>
<body>
    <?php
        
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $user_query = mysqli_query($con, "SELECT added_by FROM posts WHERE post_id='$post_id'");
        $row = mysqli_fetch_array($user_query);

        $posted_to = $row['added_by'];

        if(isset($_POST['postComment' . $post_id])){
            $post_body = $_POST['post_body'];
            $post_body = mysqli_escape_string($con, $post_body);
            $date_time_now = date("Y-m-d H:i:s");
            $insert_post = mysqli_query($con, "INSERT INTO comments VALUES (NULL, '$post_body', '$user_logged_in', '$posted_to', '$date_time_now', 'no', '$post_id')");
        }
    ?>

    <form action="cmnt_frame.php?post_id=<?php echo $post_id; ?>" id="comment-form" name="postComment<?php echo $post_id; ?>" class="comment-box" method="POST">
        <textarea class='form-control' name="post_body" placeholder='Add Comment'></textarea>
        <input type="submit" value="Comment" name="postComment<?php echo $post_id; ?>" class="btn-primary btn">
    </form>

    <!-- LOAD COMMENTS -->
    <?php
        $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY comment_id ASC");
        $count = mysqli_num_rows($get_comments);

        if($count != 0){
            while($comment = mysqli_fetch_array($get_comments)){
                $comment_body = $comment['post_body'];
                $posted_to = $comment['posted_to'];
                $posted_by = $comment['posted_by'];
                $date_added = $comment['date_added'];
                $removed = $comment['removed'];

                // grabs timeframe
                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($date_added); //time posted
                $end_date = new DateTime("$date_time_now"); //time now
                $interval = $start_date -> diff($end_date); //difference

                if($interval -> y >= 1){
                    if($interval == 1){
                        $time_msg = $interval -> y . " year ago";
                    }
                    else{
                        $time_msg = $interval -> y . " years ago";
                    }
                }
                else if ($interval -> m >= 1){
                    if($interval -> d == 0){
                        $days = " ago";
                    }
                    else if($interval -> d == 1){
                        $days = $interval -> d . " day ago";
                    }
                    else{
                        $days = $interval -> d . " days ago";
                    }

                    if($interval -> m == 1){
                        $time_msg = $interval -> m . " month" . $days;
                    }
                    else{
                        $time_msg = $interval -> m . " months" . $days;
                    }
                }
                else if ($interval -> d >= 1){
                    if($interval -> d == 1){
                        $time_msg = "Yesterday";
                    }
                    else{
                        $time_msg = $interval -> d . " days ago";
                    }
                }
                else if ($interval -> h >= 1){
                    if($interval -> h == 1){
                        $time_msg = $interval -> h . " hour ago";
                    }
                    else{
                        $time_msg = $interval -> h . " hours ago";
                    }
                }
                else if ($interval -> i >= 1){
                    if($interval -> i == 1){
                        $time_msg = $interval -> i . " minute ago";
                    }
                    else{
                        $time_msg = $interval -> i . " minutes ago";
                    }
                }
                else{
                    if($interval -> s < 30){
                        $time_msg = "Just now";
                    }
                    else{
                        $time_msg = $interval -> s . " seconds ago";
                    }
                }

                $user_obj = new User($con, $posted_by);
                ?>

                <div class="comments-section">
                    <div class="comments">
                        <a href="<?php echo $posted_by; ?>" target="_parent">
                            <div class="profile-pic">
                                <img src="<?php echo $user_obj -> getProfilePic(); ?>" title="<?php echo $posted_by; ?>" alt="">
                            </div>
                        </a>
                        <div class="info">
                            <div class="user-name">
                                <a href="<?php echo $posted_by; ?>" target="_parent">
                                    <b><?php echo $user_obj -> getFirstLastName(); ?></b>
                                </a>
                                <small><?php echo $time_msg; ?></small>
                            </div>
                            <div class="user-comment"><?php echo $comment_body; ?></div>
                        </div>
                    </div>
                </div>

                <?php  
            }
        }
        else{
            echo "<center><br>Be the first to comment!</center>";
        }
    ?>

    <!------------------------------- JAVASCRIPT -------------------------------->
    <script src="assets/js/home.js?v=<?php echo time(); ?>"></script>
</body>
</html>