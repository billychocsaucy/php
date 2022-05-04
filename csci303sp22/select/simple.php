<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/17/2022
  * Time:  10:59 AM
*/

$pagename="Simple Employee Data";
require_once '../header.php';

//query the data
$sql = "SELECT * FROM employees ORDER BY last_name";

//execute the query
$result = $pdo ->query($sql);

//loop through and display the results
foreach ($result as $row) {
    echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}

foreach ($result as $row) {
    echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}

print_r($result);

require_once '../footer.php';