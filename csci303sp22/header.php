<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/3/2022
  * Time:  11:13 AM
*/

//Session Start - Add the code (start at the beginning of the next line) when instructed.
session_start();

//Error Reporting - Add the code (start at the beginning of the next line) when instructed.
error_reporting(E_ALL);
ini_set('display_errors','1');


//Include Files - Add the code (start at the beginning of the next line) when instructed.
##DATABASE FILE
require_once 'connect.php';
##CHECK DUPLICATES FILE
require_once 'functions.php';

//Current File - Add the code (start at the beginning of the next line) when instructed.
$currentfile = basename($_SERVER['SCRIPT_FILENAME']);

//Current Date/Time  - Add the code (start at the beginning of the next line) when instructed.
$todaysdate = new DateTime() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>wjadams</title>

    <!-- Style Sheet - Add the code (start at the beginning of the next line) when instructed. -->
<link rel="stylesheet" href="phpstyles.css">
    <!-- TinyMCE - Add the code (start at the beginning of the next line) when instructed. -->
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<header>
    <h1>William Adams</h1>
    <?php
    if (isset($_SESSION['ID'])) {
        echo "<p><img src='/uploads/" . $_SESSION['file'] . "' target='_blank' alt=''></img></p>";
    }
    ?>

    <nav><?php
        // Navigation - Add the code (start at the beginning of the next line) when instructed.
    /* #Form part of nav bar
        if ($currentfile == 'form.php') {
            echo "<a href='index.php'>Home</a>";
            echo " | Form | ";
            echo "<a href='insert.php'>Insert</a>";
            echo " | ";
        }
    #Insert part of nav bar
        if ($currentfile == 'insert.php') {
            echo "<a href='index.php'>Home</a>";
            echo " | ";
            echo "<a href='form.php'>Form</a>";
            echo " | ";
        }
    */
    #Session part of nav bar
        ## If user is logged in
        if (isset($_SESSION['ID'])) {
            ## MOVIE CONFIRM PAGE
            if ($currentfile == 'movieconfirm.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                if (!empty($_SESSION['status'])) {
                    echo "<a href='adminupdateprofile.php'>Admin Profile</a>";
                } else {
                    echo "<a href='updateprofile.php'>Profile</a>";
                }
                echo " | ";
                echo "<a href='movielogout.php'>Log Out</a>";
            }
            ## MOVIE HOME PAGE
            if ($currentfile == 'index.php') {
                echo "Home | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                if (!empty($_SESSION['status'])) {
                    echo "<a href='adminupdateprofile.php'>Admin Profile</a>";
                } else {
                    echo "<a href='updateprofile.php'>Profile</a>";
                }
                echo " | ";
                echo "<a href='movielogout.php'>Logout</a>";
            }
            ## MOVIE LIST PAGE
            if ($currentfile == 'movielist.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "Movie List";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                if (!empty($_SESSION['status'])) {
                    echo "<a href='adminupdateprofile.php'>Admin Profile</a>";
                } else {
                    echo "<a href='updateprofile.php'>Profile</a>";
                }
                echo " | ";
                echo "<a href='movielogout.php'>Logout</a>";
            }
            ## MOVIE SEARCH PAGE
            if ($currentfile == 'moviesearch.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "Movie Search";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                if (!empty($_SESSION['status'])) {
                    echo "<a href='adminupdateprofile.php'>Admin Profile</a>";
                } else {
                    echo "<a href='updateprofile.php'>Profile</a>";
                }
                echo " | ";
                echo "<a href='movielogout.php'>Logout</a>";
            }
            ## MOVIE REVIEW PAGE
            if ($currentfile == 'moviereview.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "Movie Review";
                echo " | ";
                if (!empty($_SESSION['status'])) {
                    echo "<a href='adminupdateprofile.php'>Admin Profile</a>";
                } else {
                    echo "<a href='updateprofile.php'>Profile</a>";
                }
                echo " | ";
                echo "<a href='movielogout.php'>Logout</a>";
            }
            ## ADMIN PROFILE PAGE
            if ($currentfile == 'adminupdateprofile.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                echo "Admin Profile";
                echo " | ";
                echo "<a href='movielogout.php'>Log Out</a>";
            }
            ## PROFILE PAGE
            if ($currentfile == 'updateprofile.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='moviereview.php'>Movie Review</a>";
                echo " | ";
                echo "Profile";
                echo " | ";
                echo "<a href='movielogout.php'>Log Out</a>";
            }
        ##If user is not logged in
        } else {
            ## MOVIE HOME PAGE
            if ($currentfile == 'index.php') {
                echo "Home | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='movielogin.php'>Sign In</a>";
            }
            ## MOVIE LIST PAGE
            if ($currentfile == 'movielist.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "Movie List";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='movielogin.php'>Sign In</a>";
            }
            ## MOVIE SEARCH PAGE
            if ($currentfile == 'moviesearch.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "Movie Search";
                echo " | ";
                echo "<a href='movielogin.php'>Sign In</a>";
            }
            ## MOVIE LOGIN PAGE
            if ($currentfile == 'movielogin.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "Sign In";
                echo " | ";
                echo "<a href='register.php'>Register</a>";
            }
            ## MOVIE REGISTER PAGE
            if ($currentfile == 'register.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='movielogin.php'>Sign In</a>";
                echo " | ";
                echo "Register";
            }
            ## MOVIE CONFIRM PAGE
            if ($currentfile == 'movieconfirm.php') {
                echo "<a href='index.php'>Home</a>";
                echo " | ";
                echo "<a href='movielist.php'>Movie List</a>";
                echo " | ";
                echo "<a href='moviesearch.php'>Movie Search</a>";
                echo " | ";
                echo "<a href='movielogin.php'>Sign In</a>";
            }
        }
        ## If user has admin privileges
        if (!empty($_SESSION['status'])) {

        }
        ?>
    </nav>
</header>
<main>
    <h2><?php echo $pagename;//This variable is defined before the header file is included. ?></h2>
    <hr>