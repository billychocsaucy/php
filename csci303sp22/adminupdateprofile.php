<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Admin Update User Profile";
require_once "header.php";
unset($_SESSION['mname']);




//TRACKING THE ID ADMIN OR NOT
if (isset($_SESSION['ID'])) {
    $ID = $_SESSION['ID'];
    $showform = 1;

##ERROR VARIABLES
$errmsg = 0;
$adminchoicerr = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form
    #print_r($_FILES);
    #print_r($_SESSION['file']);
    #print_r($_FILES['file']['tmp_name']);


    ##LOCAL VARIABLES
    $adminchoice = $_POST['adminchoice'];


    if (isset($adminchoice)) {
        ##SHOW USER PROFILE SELECTED
        $sqlh = "SELECT * FROM project_viewers WHERE uname = :adminchoice ";
        $stmt = $pdo->prepare($sqlh);
        $stmt->bindValue(':adminchoice', $adminchoice);
        $stmt->execute();
        $rowh = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['UID'] = $rowh['vid'];
//        $_SESSION['UID'] = $rowh['vid'];
//        $_SESSION['UID'] = $rowh['vid'];
//        $_SESSION['UID'] = $rowh['vid'];
        header("Location: updateprofile.php");

    }

}// closing of if server method is post

##ADMIN FORM FIELD CODE
if ($showform == 1) {
            echo "Hello Admin<br>"; ?>
            <form name="adminform" id="WilliamAdamsadmin" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">
            <?php

            $sqla = "SELECT DISTINCT uname FROM project_viewers";
            $stmt = $pdo->prepare($sqla);
            $stmt->execute();
            $resulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <br><label for="adminchoice">What user profile will you update? </label><select name="adminchoice" id="adminchoice">
                <?php foreach ($resulta as $row) { ?>
                    <option value="<?php echo $row['uname'];  // gives the value?>"
                        <?php if (isset($adminchoice) && $adminchoice == $row['uname']) { echo " selected ";}?>>
                        <?php echo $row['uname']; // list all genres in the dropdown box?></option>
                    <?php
                } // end of foreach
                ?>
            </select><br><br>

            <!-- Submit code -->
            <label for="submit">Submit:  </label><input type="submit" name="submit" id="submit" value="submit"><br><br>
    </form> <?php
}
}
require_once "footer.php";
?>

