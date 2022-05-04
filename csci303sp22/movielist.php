<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/15/2022
  * Time:  9:41 AM
*/
$pagename="Movie List";
require_once 'header.php';

if (!empty($_SESSION['status'])) { ?>
        <p>Click on Update to add to the movie list.</p>
    <a href="movieupdate.php"><input type="submit" name="submit" id="submit" value="Update"></a>
<?php }

if (isset($_SESSION['mname'])) {
    echo "<span class='success'>You have successfully updated the movie list!</span><br><br>";
}

//query the data
$sql = "SELECT * FROM project_movies WHERE NOT mid = 1  ORDER BY mname ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<p>Click on Movie Name to create a review or click on details to see the reviews for that movie.</p>
<table>
    <tr><th>Movie Details</th><th>Movie Name</th><th>Genre</th></tr>
<?php
//loop through the results and display to the screen
foreach ($result as $row){
    ?>
    <tr><td><a href="moviedetails.php?q=<?php echo $row['mid'];?>">Details</a></td>
        <td><a href="moviereview.php?q="><?php echo $row['mname'];?></a></td>
        <td><?php echo $row['genre'];?></td>
    </tr>
    <?php
}
?>
</table>
<?php
require_once 'footer.php';
