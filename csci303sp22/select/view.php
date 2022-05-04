<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/15/2022
  * Time:  9:41 AM
*/
$pagename=" View Employee Data";
require_once '../header.php';

if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
    echo "You cannot see this data, go back to options or list";
} else {


    //query the data
    $sql = "SELECT * FROM sm_employees WHERE emp_no = :emp_no";

    //prepares a statement for execution
    $stmt = $pdo->prepare($sql);

    //binds the actual value of $_GET['q'] to placeholder for employee
    $stmt->bindValue(':emp_no', $_GET['q']);

    //executes a prepared statment
    $stmt->execute();

    //fetches the next row from a result set / returns an array
    //default: array indexed by both column name and 0-indexed column number
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <!-- <h3>Contents of print_r</h3> -->

    <?php
    //display contents of array:
    ##print_r($row);
    ##echo "<hr>";
    ?>

    <h3>Displaying Data to the Screen</h3>
    <?php
    //display to the screen
    ##echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}
?>
Employee ID: <?php echo $row['emp_no'];?><br>
Department Number: <?php echo $row['fk_dept_no'];?><br>
Birth Date: <?php echo $row['birth_date'];?><br>
First Name: <?php echo $row['first_name'];?><br>
Last Name: <?php echo $row['last_name'];?><br>
Gender: <?php echo $row['gender'];?><br>
Hire Date: <?php echo $row['hire_date'];?><br>
<?php
require_once '../footer.php';
