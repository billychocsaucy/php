<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/17/2022
  * Time:  10:59 AM
*/

$pagename="Movie Search";
require_once 'header.php';
unset($_SESSION['mname']);
?>
<p>Please enter a Movie Name</p>
<form name="search" id="search" method="get" action="<?php echo $currentfile; ?>">
    <label for="mterm">Search Movie Name:</label>
    <input type="search" id="mterm" name="mterm" placeholder="Search for Movie Name">
    <input type="submit" id="msearch" name="msearch" value="Search">
</form>

<?php
if (isset($_GET['msearch'])) {
    if (empty($_GET['mterm'])) {
        echo "<p class='error'>You did not search anything! Please try again.</p>";
    } else {
        $mterm = trim($_GET['mterm']) . "%";
        //SELECT FROM THE DATABASE
        //ORDERED BY LAST NAME IN ASCENDING ORDER
        $sql = "SELECT * FROM project_movies WHERE mname LIKE :mterm ORDER BY mname ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mterm', $mterm);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty ($result)) {
            //IF THERE ARE NO RESULTS, LET THE USER KNOW
            echo "<p class='error'>We did not find any results for " . htmlspecialchars($_GET['mterm'])
                . ". Please search again.</p>";
        } else {
            echo "<p class='success'>We found results for "
                . htmlspecialchars($_GET['mterm']) . "</p>";
            ?>
            <table>
            <tr><th>Movie Name</th><th>Genre</th></tr>
            <?php
            foreach($result as $row) {
                ?>
                <tr><td><a href="moviedetails.php?q=<?php echo $row['mid'];?>"><?php echo $row['mname'];?></a></td>
                    <td><?php echo $row['genre'];?></td>
                </tr>
                <?php
            }//foreach
            ?></table><?php
        } // else if empty results
    } // else if empty
} // if isset
require_once 'footer.php';