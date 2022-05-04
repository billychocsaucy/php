<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/15/2022
  * Time:  9:41 AM
*/
$pagename="Fetchall Employee Data";
require_once '../header.php';

//query the data
$sql = "SELECT * FROM employees ORDER BY last_name";

//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//executes a prepared statment
$stmt->execute();

//fetches the next row from a result set / returns an array
//default: array indexed by both column name and 0-indexed column number
$result = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<h3>Contents of print_r</h3>

<?php
//display contents of array:
print_r($result);
echo "<hr>";
?>

<h3>Displaying Data to the Screen</h3>
<?php
//loop through the results and display to the screen
foreach ($result as $row){
    echo $row['emp_no'] . " - " . $row['last_name']. "<br>";
}
require_once '../footer.php';
