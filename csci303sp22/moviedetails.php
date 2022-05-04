<?php

/*
    * Class: csci303sp22
    * User: wjadams
    * Date: 4/28/2022
    * Time: 3:08 PM
*/

$pagename = "Movie Details";
require_once "header.php";
/*
##ERROR VARIABLES
$errmsg = 0;
$movielisterr = "";
$revtitleerr = "";
$recomerr = "";
$detailserr = "";
*/

## MY QUERIES
$sql = "SELECT * FROM project_reviews 
     JOIN project_movies ON project_reviews.fk_mid = project_movies.mid
          JOIN project_viewers ON project_reviews.fk_vid = project_viewers.vid
    WHERE mid = :mid ORDER BY revtitle ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mid', $_GET['q']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//$sqlv = "SELECT * FROM project_reviews
//    INNER JOIN project_viewers ON project_reviews.fk_vid = project_viewers.vid
//    WHERE vid = :vid ORDER BY revtitle ASC";
//$stmt = $pdo->prepare($sqlv);
//$stmt->bindValue(':vid', $_SESSION['ID']);
//$stmt->execute();
//$rowv = $stmt->fetch(PDO::FETCH_ASSOC);
//$resultv = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($row['fk_mid'])) { #If there are no reviews
    echo "<h4>There are no reviews for this Movie yet.</h4>";
    if (isset($_SESSION['ID'])) {
        echo "<h4>If you would like to create a review go <a href='moviereview.php'>here</a></h4>";#Links to movie review page
    } else {
        echo "<h4>If you would like to create a review go <a href='movielogin.php'>here</a></h4>";#Links to sign in page
    }
} else {
    if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
        echo "You're not supposed to see this go back!";
    } else {
        ##Display Movie Name
        echo "<h3>" . $row['mname'] . "</h3>";

        ##Display Movie Reviews
        echo "<h4>Reviews</h4>";

        ?><div class="details"><?php
        #Display Review Name
        echo "Review Name: " . $row['revtitle'] . "<br>";

        #Display Viewer Name
        echo "Viewer Name: " . $row['uname'] . "<br>";

        #Display Review Recommendation
        if ($row['recom'] == "Y") {
            echo "Recommendation: Yes <br>";
        } elseif ($row['recom'] == "N") {
            echo "Recommendation: No <br>";
        } elseif ($row['recom'] == "U") {
            echo "Recommendation: Not Sure <br>";
        }
        #Display Viewer Thoughts
        echo "Viewer Comments: " . $row['details'] . "<br>";


        #Display all Review Forms
        foreach ($result as $row) {
        ##Display Review Form

            #Display Review Name
            echo "Review Name: " . $row['revtitle'] . "<br>";

            #Display Viewer Name
            echo "Viewer Name: " . $row['uname'] . "<br>";

            #Display Review Recommendation
            if ($row['recom'] == "Y") {
                echo "Recommendation: Yes <br>";
            } elseif ($row['recom'] == "N") {
                echo "Recommendation: No <br>";
            } elseif ($row['recom'] == "U") {
                echo "Recommendation: Not Sure <br>";
            }
            #Display Viewer Thoughts
            echo "Viewer Comments: " . $row['details'] . "<br>";
            }

        }
    ?></div><?php



}
require_once "footer.php";