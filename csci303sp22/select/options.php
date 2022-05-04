<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/15/2022
  * Time:  9:41 AM
*/
$pagename="Options Employee Data";
require_once '../header.php';

//query the data
$sql = "SELECT emp_no, first_name, last_name FROM sm_employees ORDER BY last_name";

//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//executes a prepared statment
$stmt->execute();

//fetches the next row from a result set / returns an array
//default: array indexed by both column name and 0-indexed column number
$result = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!-- <h3>Contents of print_r</h3> -->

<?php
//display contents of array:
##print_r($result);
##echo "<hr>";
?>

<h3>Displaying Data to the Screen</h3>
<table>
    <tr><th>Options</th><th>First Name</th><th>Last Name</th></tr>
<?php
//loop through the results and display to the screen
foreach ($result as $row){
    ?>
    <tr><td><a href="view.php?q=<?php echo $row['emp_no'];?>">View</a> |
            <a href="join.php?q=<?php echo $row['emp_no'];?>">Join</a> |
            <a href="../update.php?q=<?php echo $row['emp_no'];?>">Update</a> |
            <a href="delete.php?q=<?php echo $row['emp_no'];?>&l=<?php echo $row ['last_name'];?>">Delete</a></td>
        <td><?php echo $row['first_name'];?></td>
        <td><?php echo $row['last_name'];?></td>
    </tr>
    <?php
}
?>
</table>
<?php
require_once '../footer.php';
