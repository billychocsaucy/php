<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/31/2022
  * Time:  10:37 AM
*/
session_start();
session_unset();
session_destroy();
$state = 0;
header("Location: confirm.php?state=1");