<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/24/2022
  * Time:  10:17 AM
*/

$pagename = "Delete";
require_once '../header.php';

$showform = 1;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "DELETE FROM sm_employees WHERE emp_no = :emp_no;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':emp_no', $_POST['emp_no']);
    $stmt->execute();
    echo "<p>You have successfully deleted <strong>" . $_POST['last_name'] . "</strong></p>";
    $showform = 0;
} if ($showform == 1) {
?>
    <p>Are you sure you want to delete <strong><?php echo $_GET['l'];?></strong>.</p>
    <form id="delete" name="delete" method="post" action="<?php echo $currentfile; ?>">
        <input type="hidden" id="emp_no" name="emp_no" value="<?php echo $_GET['q']; ?>">
        <input type="hidden" id="last_name" name="last_name" value="<?php echo $_GET['l']; ?>">
        <input type="submit" id="delete" name="delete" value="CONFIRM">
    </form>
    <?php
}
require_once '../footer.php';