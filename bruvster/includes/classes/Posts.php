<?php
    class Posts{
        private $user_obj;
        private $con;

        public function __construct($con, $user){
            $this -> con = $con; // references variable $con
            $this -> user_obj = new User($con, $user);
        }

        public function submitPost($body, $user_to, $imageName){
            $body = strip_tags($body); //removes html tags
            $body = mysqli_real_escape_string($this -> con, $body);

            $check_empty = preg_replace('/\s+/', '', $body); //removes whitespaces

            if($check_empty != ""){
                //takes date and time
                $date_added = date("Y-m-d H:i:s");
                //grabs username
                $added_by = $this -> user_obj -> getUsername();

                //setting user_to to none if user is on their profile
                if($user_to == $added_by){
                    $user_to = "none";
                }

                // insert post
                $query = mysqli_query($this -> con, "INSERT INTO posts VALUES(NULL, '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$imageName')");

                $returned_id = mysqli_insert_id($this -> con);

                // add notification

                //Update post count
                $num_posts = $this -> user_obj -> getNumPosts();
                $num_posts++;
                $update_query = mysqli_query($this -> con, "UPDATE users SET num_posts = '$num_posts' WHERE username='$added_by'");
            }
        }

        public function loadPostsFriends(){
            $str = "";
            $user_logged_in = $this -> user_obj -> getUsername();
            $data = mysqli_query($this -> con, "SELECT * FROM posts WHERE deleted_post='no' ORDER BY post_id DESC");

            while ($row = mysqli_fetch_array($data)) {
                $id = $row['post_id'];
                $body = $row['post_body'];
                $added_by = $row['added_by'];
                $date_time = $row['date_added'];
                $imagePath = $row['image'];

                if($row['user_to'] == "none"){
                    $user_to ="";
                }
                else{
                    $user_to_obj = new User($con, $row['user_to']);
                    $user_to_name = $user_to_obj -> getFirstLastName();
                    $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
                }

                //checks if account is closed
                $added_by_obj = new User($this -> con, $added_by);
                if($added_by_obj -> isClosed()){
                    continue;
                }

                if($user_logged_in == $added_by){
                    $delete_btn = "<button class='deleteBtn' id='post$id'>
                                        <span class='delete'><i class='bi bi-x-circle-fill'></i></span>
                                    </button>";
                }else{
                    $delete_btn = "";
                }

                $user_info_query = mysqli_query($this -> con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                $user_row = mysqli_fetch_array($user_info_query);
                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];
                
                // displays the number of comments in each post
                $comments_check = mysqli_query($this -> con, "SELECT * FROM comments WHERE post_id='$id'");
                $comments_check_count = mysqli_num_rows($comments_check);

                // grabs timeframe
                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($date_time); //time posted
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

                if($imagePath != ""){
                    $imageDiv = "<div class='feed-photo'>
                                    <img src='$imagePath' alt=''>
                                </div>";
                }
                else{
                    $imageDiv = "";
                }

                $str .= "<div class='feeds'>
                            <div class='feed-post'>
                                <div class='head'>
                                    <div class='user'>
                                        <div class='profile-pic'>
                                            <img src='$profile_pic' alt=''>
                                        </div>
                                        <div class='info'>
                                            <a href='$added_by'><h3>$first_name $last_name</h3></a> $user_to
                                            <small>$time_msg</small>
                                        </div>
                                    </div>
                                    $delete_btn
                                </div>

                                $imageDiv

                                <div class='feed-caption'>
                                    <p>$body</p>
                                </div>

                                <div class='feed-btns'>
                                    <div class='action-btns'>
                                        <button class='likeBtn'>
                                            <span><i class='bi bi-emoji-neutral data-id='$id'></i></span>&nbsp;<small class='num-likes data-id='$id'>0<small>
                                        </button>
                                        <button class='cmntBtn' data-id='$id'>
                                            <span><i class='bi bi-chat'></i></span>&nbsp;<small>$comments_check_count<small>
                                        </button>
                                    </div>
                                </div>

                                <div class='feed-comments feed-comments-$id'>
                                    <iframe src='cmnt_frame.php?post_id=$id' allowtransparency='true' id='comment_iframe' frameborder='0'></iframe>
                                </div>
                            </div>
                        </div>";
            }
            
            echo $str;
        }
    }
?>