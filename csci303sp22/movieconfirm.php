<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/31/2022
  * Time:  2:47 PM
*/
$pagename = "Confirmation";
require_once "header.php";

if ($_GET['state'] == 1) {  ## Loging out
    echo "<span class='success'>You have logged out</span>";
} elseif ($_GET['state'] == 2) {  ## Loging in
    echo "<span class='success'>Welcome " . $_SESSION['uname'] . "</span>";
} elseif ($_GET['state'] == 3) {  ## Loging in
    echo "<span class='success'>You have successfully reset your password.</span>";
}

require_once "footer.php";