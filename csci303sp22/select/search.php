<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/17/2022
  * Time:  10:59 AM
*/

$pagename="Simple Employee Search";
require_once '../header.php';
?>
<link rel="stylesheet" href="../phpstyles.css">

<p>Please enter the first letter of your employee's last name:</p>
<form name="lnsearch" id="lnsearch1" method="get" action="<?php echo $currentfile; ?>">
    <label for="lnterm">Search Employee Last Name:</label>
    <input type="search" id="lnterm" name="lnterm" placeholder="Search for Last Name">
    <input type="submit" id="lnsearch" name="lnsearch" value="Go">
</form>

<?php
if (isset($_GET['lnsearch'])) {
    if (empty($_GET['lnterm'])) {
        echo "<p class='error'>There is no input! Try again please.</p>";
    } else {
        $lnterm = trim($_GET['lnterm']) . "%";
        //SELECT FROM THE DATABASE
        //ORDERED BY LAST NAME IN DESCENDING ORDER
        $sql = "SELECT last_name, first_name FROM employees WHERE last_name LIKE :lnterm ORDER BY last_name DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':lnterm', $lnterm);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty ($result)) {
            //IF THERE ARE NO RESULTS, LET THE USER KNOW
            echo "<p class='error'>We did not find any results for " . htmlspecialchars($_GET['lnterm'])
                . ". Please search again.</p>";
        } else {
            echo "<p class='success'>We found results for </p>"
                . htmlspecialchars($_GET['lnterm']) . "<br>";
            foreach($result as $row) {
                echo $row['last_name'] . " " . $row['first_name'] . "<br>";
            }//foreach
        } // else if empty results
    } // else if empty
} // if isset
require_once '../footer.php';