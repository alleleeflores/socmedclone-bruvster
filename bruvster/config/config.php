<?php
    ob_start(); //turns on output buffering
    session_start(); //allwos to store values of variables to session variables
    
    $timezone = date_default_timezone_set("Asia/Dubai");

    $con = mysqli_connect("localhost", "root", "", "bruvsterdb");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>