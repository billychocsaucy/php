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
    echo "You have logged out";
} elseif ($_GET['state'] == 2) {  ## Loging in
    echo "Welcome " . $_SESSION['email'];
}

require_once "footer.php";