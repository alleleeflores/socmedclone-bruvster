<?php
    include("includes/header.php");
    include("includes/classes/User.php");
    include("includes/classes/Posts.php");

    if(isset($_POST['submit-post'])){
        $uploadOk = 1;
        $imageName = $_FILES['filetoUpload']['name'];
        $php_errormsg = "";

        if($imageName != ""){
            $targetDir = "assets/img/posts/";
            $imageName = $targetDir . uniqid() . basename($imageName);
            $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

            if($_FILES['fileToUpload']['size'] > 10000000){
                $php_errormsg = "Sorry, the file was too epic!";
                $uploadOk = 0;
            }

            if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg"){
                $php_errormsg = "Sorry, the file was not like other girls! Gotta be a jpeg, jpg or png, bruv!";
                $uploadOk = 0;
            }

            if($uploadOk){
                if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){

                }else{
                    $uploadOk = 0;
                }
            }
        }

        if($uploadOk){
            $post = new Posts($con, $user_logged_in);
            $post -> submitPost($_POST['create-post'], 'none' , $imageName);
            header("Location: home.php");
        }else{
            echo "<div style='text-align: center;'>$php_errormsg</div>";
        }
    }
?>
    <!------------------------------- MAIN -------------------------------->
    <main>
        <div class="container">
            <!-- LEFT -->
            <div class="left-content">
                <a href="#" class="profile">
                    <div class="profile-pic">
                        <img src="<?php echo $user['profile_pic']; ?>" alt="">
                    </div>
                    <div class="user-info">
                        <h1><?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>
                        <p class="text-muted">@<?php echo $user['username']; ?></p>
                    </div>
                </a>

                <!-- MENU ITEMS -->
                <div class="sidebar">
                    <a href="#" class="menu-item active">
                        <span><i class="bi bi-house-door-fill"></i></span> <h3>Home</h3>
                    </a>

                    <a href="#" class="menu-item" id="notifs">
                        <span><i class="bi bi-bell-fill"><small class="notif-count">6</small></i></span><h3>Notifications</h3>
                        <!-- notifications -->
                        <div class="notif-popup">
                            <!----------------- 1 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-10.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Alaina Deleon</b> accepted your friend request.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <!----------------- 2 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-11.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Robson Cameron</b> commented on your post.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <!----------------- 3 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-12.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Tiernan Werner</b> tagged you in a post.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <!----------------- 4 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-13.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Phillip Floyd</b> accepted your friend request.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <!----------------- 5 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-14.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Margaux Buxton</b> commented on your post.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <!----------------- 6 ----------------->
                            <div>
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-15.jpeg" alt="">
                                </div>
                                <div class="notif-body">
                                    <b>Clark Kerr</b> tagged you in a post.
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="#" class="menu-item" id="messages-notifs">
                        <span><i class="bi bi-envelope-fill"><small class="notif-count">9+</small></i></span> <h3>Messages</h3>
                    </a>

                    <a href="#" class="menu-item">
                        <span><i class="bi bi-people-fill"></i></span> <h3>Friends</h3>
                    </a>

                    <a href="#" class="menu-item" id="theme-custom">
                        <span><i class="bi bi-droplet-fill"></i></span> <h3>Theme</h3>
                    </a>

                    <a href="settings.php" class="menu-item">
                        <span><i class="bi bi-gear-fill"></i></span> <h3>Settings</h3>
                    </a>
                </div>
                <!------------------------------- SIDEBAR CLOSE -------------------------------->

                <a href="includes/handlers/logout.php" class="btn btn-primary">Log Out</a>
            </div>
            <!-- MIDDLE -->
            <div class="middle-content">
                <!-- CREATE POSTS -->
                <form action="home.php" method="POST" class="create-post">
                    <div class="profile-pic">
                        <img src="<?php echo $user['profile_pic']; ?>" alt="">
                    </div>
                    <!-- TEXT AREA -->
                    <input type="text" name="create-post" id="create-post" placeholder="You alright, bruv?">
                    <!-- SUBMIT BUTTON -->
                    <input type="submit" name="submit-post" id="post-btn" value="Post" class="btn btn-primary">
                </form>

                <!-- FEEDS -->
                <?php
                    $post = new Posts($con, $user_logged_in);
                    $post -> loadPostsFriends();
                ?>
            </div>
            <!-- RIGHT -->
            <div class="right-content">
                <div class="messages">
                    <div class="heading">
                        <h4>Messages</h4><i class="bi bi-pencil-square"></i>
                    </div>

                    <div class="search-bar">
                        <i class="bi bi-search"></i>
                        <input type="search" name="#" placeholder="Search messages..." id="message-search" onkeyup="searchMsg()"> <!-- onkeyup="searchMsg()"-->
                    </div>

                    <div class="category">
                        <h6 class="active">General</h6>
                        <h6 class="msg-req">Requests(1)</h6>
                    </div>

                    <!-- MESSAGES -->
                    <ul id="msg-list">
                        <li>
                            <!----------------- 1 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-1.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Vera Long</h5>
                                    <p class="text-muted">when fortnite stream, chav?</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!----------------- 2 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-2.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Pawel Valdez</h5>
                                    <p class="text-bold">wanna play roblox?</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!----------------- 3 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-3.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Colby Lin</h5>
                                    <p class="text-bold">i'm not her pogchamp anymore.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!----------------- 4 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-4.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Safiyyah Ellwood</h5>
                                    <p class="text-muted">planning to be a discord kitten..</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!----------------- 5 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-5.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Nella Driscoll</h5>
                                    <p class="text-bold">kiss the homies gn for me</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!----------------- 6 ----------------->
                            <div class="message-content">
                                <div class="profile-pic">
                                    <img src="assets/img/free/profile-6.jpeg" alt="">
                                </div>
                                <div class="msg-body">
                                    <h5>Evelina Day</h5>
                                    <p class="text-muted">What? I speak idiot!</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="friend-req">
                    <h4>Friend Requests</h4>
                    <!----------------- 1 ----------------->
                    <div class="req">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="assets/img/free/profile-7.jpeg" alt="">
                            </div>
                            <div>
                                <h5>Kofi Weiss</h5>
                                <p class="text-muted">104 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>

                    <!----------------- 2 ----------------->
                    <div class="req">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="assets/img/free/profile-8.jpeg" alt="">
                            </div>
                            <div>
                                <h5>Nevaeh Shelton</h5>
                                <p class="text-muted">20 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>

                    <!----------------- 3 ----------------->
                    <div class="req">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="assets/img/free/profile-9.jpeg" alt="">
                            </div>
                            <div>
                                <h5>Aiden Gallegos</h5>
                                <p class="text-muted">10 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!------------------------------- THEME CUSTOMIZATION -------------------------------->
    <div class="theme-custom">
        <div class="card">
            <h2>Customize the theme!</h2>
            <p class="text-muted">Only true pogchamps go dark mode.</p>

            <!-- FONT SIZES -->
            <div class="theme-fonts">
                <h3>Font Size</h3>
                <div>
                    <h6>Aa</h6>
                    <div class="font-sizes">
                        <span class="font-size-1"></span>
                        <span class="font-size-2"></span>
                        <span class="font-size-3 active"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>

            <!-- COLOR CUSTOMIZATION -->
            <div class="theme-colors">
                <h3>Color</h3>
                <div class="colors">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                </div>
            </div>

            <!-- BACKGROUND -->
            <div class="theme-bgs">
                <h3>Background</h3>
                <div class="bgs">
                    <div class="bg-lights active">
                        <span></span>
                        <h5 for="bg-lights">Lights</h5>
                    </div>
                    <div class="bg-dark">
                        <span></span>
                        <h5 for="bg-dark">Lights Out</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------------------------- JAVASCRIPT -------------------------------->
    <script src="assets/js/home.js?v=<?php echo time(); ?>"></script>
</body>
</html>
