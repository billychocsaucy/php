<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Movie Reviews Page";

require_once "header.php";
unset($_SESSION['mname']);

$showform = 1;

##ERROR VARIABLES
$errmsg = 0;
$movielisterr = "";
$revtitleerr = "";
$recomerr = "";
$detailserr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form?><br><?php
    #print_r($_SESSION['ID']);

    ##INITIAL VARIABLES
    $movielist = $_POST['movielist'];
    $revtitle = $_POST['revtitle'];
    if (isset($_POST['recom'])) {
        $recom = $_POST['recom'];
    }
    $details = $_POST['details'];
    $vid = $_SESSION['ID'];

    ##ERROR CHECKING
    #Dropdown checking
    if ($movielist == "PICK ONE") { #Check if select input is empty
        $errmsg = 1;
        $movielisterr = "<span class='error'>You haven't picked your favorite genre!!</span><br>";
    }

    #Title checking
    if (empty($revtitle)) { #Check if url/email is empty
        $errmsg = 1;
        $revtitleerr = "<span class='error'> Your review title is missing!! </span><br>";
    } else {
        ##CHECK FOR DUPLICATES
        $sql = "SELECT * FROM project_reviews WHERE revtitle = :field";
        $revtitleexists = check_duplicates($pdo, $sql, $revtitle);
        if ($revtitleexists) {
            $errmsg = 1;
            $revtitleerr .= "<span class='error'> This review name has already been made.</span><br>";
        }
    }

    #Radio checking
    if (!isset($_POST['recom'])) { #Check if radio input is empty
        $errmsg = 1;
        $recomerr = "<span class='error'> You did not select a your recommendation!! </span>";
    }

    #Text area checking
    if (empty($details)) { #Check if text area input is empty
        $errmsg = 1;
        $detailserr = "<span class='error'>You did not write about your thoughts on the movie!!</span>";
    }

    ##CONTROL CODE
    if ($errmsg != 0) {
        echo "<p class='error'>You have made an error(s). Please fix them.</p>";
    } else {
        $sql = "SELECT * FROM project_movies WHERE mid = :mid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mid', $movielist);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p class='success'>Great job! You have created a review for the movie " . $row['mname'] . ".</p>";

        ##INSERT CODE
            $sql = "INSERT INTO project_reviews (fk_mid, revtitle, recom, details, fk_vid) VALUES (:fk_mid, :revtitle, :recom, :details, :fk_vid)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':fk_mid', $movielist);
            $stmt->bindValue(':revtitle', $revtitle);
            $stmt->bindValue(':recom', $recom);
            $stmt->bindValue(':details', $details);
            $stmt->bindValue(':fk_vid', $vid);
            $stmt->execute();
            $showform = 0;

        ##SEND EMAIL CODE
        $Subject = "Movie Reviews";
        $Body = "<p style='color:cornflowerblue'>You have successfully created a review for the movie " . $row['mname'] . ".</p>";
        $AltBody = 'You have successfully created a review.';
        $email = $_SESSION['email'];
        $fname = $_SESSION['uname'];
        $EmailOkay = "You will be receiving a confirmation email for creating a review.";
        $EmailFail = "An error occurred trying to send the email. The email did not send.";
        $sendEmail = sendEmail($Subject, $Body, $AltBody, $email, $fname);
        }
}// closing of if server method is post

##FORM FIELD CODE
if ($showform == 1)
{
    ?>
    <p> ** All Fields are required ** </p>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">

        <!-- Movie list selection code -->
        <?php
        if (isset($movielisterr)) {
            echo $movielisterr;
        }
        $sql = "SELECT DISTINCT mname, mid FROM project_movies ORDER BY mid ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="movielist">Which movie are you reviewing? </label><select name="movielist" id="movielist">
            <?php foreach ($result as $row) { ?>
                <option value="<?php echo $row['mid'];  // gives the value?>"
                    <?php if (isset($movielist) && $movielist == "") { echo " selected ";}  // repopulates value if submit is hit?>>
                    <?php echo $row['mname']; // list all genres in the dropdown box?></option>
                <?php
            } // end of foreach
            ?>
        </select><br><br>

        <!-- Review Title code -->
        <?php
        if (isset($revtitleerr)) {
            echo $revtitleerr;
        }
        ?>
        <label for="revtitle">What will be the review title name? </label>
        <input type="text" name="revtitle" id="revtitle" placeholder="Title" value="<?php if(isset($revtitle)){ echo htmlspecialchars($revtitle);}?>"><br>

        <!-- Review Recommendation code -->
        <?php
        if (isset($recomerr)) {
            echo $recomerr;
        }
        ?>
        <p>Do you recommend this movie?</p>
        <input type="radio" name="recom" id="recom0" value="Y"
            <?php if (isset($recom) && $recom == "Y") {echo " CHECKED ";}?>>
        <label for="recom0">Yes</label><br>

        <input type="radio" name="recom" id="recom1" value="N"
            <?php if (isset($recom) && $recom == "N") {echo " CHECKED ";}?>>
        <label for="recom1">No</label><br>

        <input type="radio" name="recom" id="recom2" value="U"
            <?php if (isset($recom) && $recom == "U") {echo " CHECKED ";}?>>
        <label for="recom2">Not Sure</label><br>

        <!-- Details code -->
        <?php
        if (isset($detailserr)) {
            echo $detailserr;
        }
        ?>
        <br> <label for="details">What are your comments on the movie?</label><br>
        <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
        <textarea name="details" id="details" rows="3" cols="20"><?php if (isset($details)) { echo $details; }?></textarea><br><br>


        <!-- Submit code -->
        <label for="submit">Submit:  </label><input type="submit" name="submit" id="submit" value="submit"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
require_once "footer.php";
?>

