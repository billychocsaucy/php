<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Update User Profile";
require_once "header.php";
unset($_SESSION['mname']);




//TRACKING THE ID ADMIN OR NOT
if (isset($_SESSION['ID'])) {
    $ID = $_SESSION['UID'];
    $showform = 1;

    ?>

    <!-- Password code -->
        <!--        --><?php
        //        if (isset($passwerr)) {
        //            echo $passwerr;
        //        }
        //        ?>
        <br><label for="passw">Reset Password: </label>
        <a href="updatepassword.php"><input type="submit" name="passw" id="passw" value="Reset"></a><br><br>

    <?php
##ERROR VARIABLES
$errmsg = 0;
$unameerr = "";
$emailerr = "";
$passwerr = "";
$favgenreerr = "";
$fileerr = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form
    #print_r($_FILES);
    #print_r($_SESSION['file']);
    #print_r($_FILES['file']['tmp_name']);


    ##FILES ERROR CHECKING
    if (empty($_FILES['file']['name'])) { #If upload file is empty
    } else { #If upload file is not empty
        if ($_FILES['file']['error'] != 0) {
            $errmsg = 1;
            $filerr = "Error uploading file.";
        } else {
            #Name of file in database and filename moved
            $pinfo = pathinfo($_FILES['file']['name']);
            $userfile = strtolower($pinfo['filename'] . $todaysdate->format('usiH') . "." . $pinfo['extension']);
            $filepath = "/var/www/html/uploads/" . $userfile;

            ##CHECK EXISTING
            if (file_exists($filepath)) {
                $errmsg = 1;
                $fileerr = "File already exists.";
            } else {
                if ($pinfo['extension'] != "jpg") {
                    $errmsg = 1;
                    $fileerr = "Wrong file type submitted! Must be jpeg!!";
                } else {
                    $imgdimensions = getimagesize($_FILES['file']['tmp_name']);
                    if ($imgdimensions[0] > 250 or $imgdimensions[1] > 300) {
                        $errmsg = 1;
                        $fileerr = "The image you uploaded is too large!!";
                    } else {
                        ##MOVE THE FILE
                        if (!move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
                            $errmsg = 1;
                            $fileerr = "Image cannot be moved.";
                        }
                    }
                }
            }
        }
    }

        ##LOCAL VARIABLES
        $uname = $_POST['uname'];
        $email = trim(strtolower($_POST['email']));
//        $passw = $_POST['passw'];
        $favgenre = $_POST['favgenre'];


        ##LOCAL VARIABLES ERROR CHECKING
        #username checking
        if (empty($uname)) { #Check if username is empty
            $errmsg = 1;
            $unameerr = "<span class='error'> Your username is missing!! </span><br>";
        } else {
            if (strlen($uname) > 20) { #Check if user input is valid
                $errmsg = 1;
                $unameerr = "<span class='error'> You have too many characters for your username!! </span><br>";
            }
        }

        #$url checking
        if (empty($email)) { #Check if url/email is empty
            $errmsg = 1;
            $emailerr = "<span class='error'> Email is missing!! </span><br>";
        } else { #Check if url/email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errmsg = 1;
                $emailerr = "<span class='error'>This is not a valid email address!!</span><br>";
            }
        }

//        #password checking
//        if (empty($passw)) { #Check if user input is empty
//            $errmsg = 1;
//            $passwerr = "<br><span class='error'> You are missing a password!! </span>";
//        } else {
//            if (strlen($passw) < 8) { #Check if user input is valid
//                $errmsg = 1;
//                $passwerr = "<br><span class='error'> Not enough characters in password!! </span>";
//            } else {
//                $hashed = password_hash($passw, PASSWORD_DEFAULT);
//            }
//        }

        #Dropdown checking
        if ($favgenre == "PICK ONE") { #Check if select input is empty
            $errmsg = 1;
            $favgenreerr = "<span class='error'>You haven't picked your favorite genre!!</span><br>";
        }


        ##UPDATE THE DATABASE
        if ($errmsg == 1) {
            echo "<p class='error'>Looks like you have errors!! Please Fix Them!!!</p>";
        } else {
            if (empty($_FILES['file']['name'])) {
                echo "<p class='success'>You have successfully updated your profile information!!!</p>";
                $sql = "UPDATE project_viewers
        SET uname = :uname, email = :email, favgenre = :favgenre
        WHERE vid = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':ID', $ID);
                $stmt->bindValue(':uname', $uname);
                $stmt->bindValue(':email', $email);
//                $stmt->bindValue(':passw', $hashed);
                $stmt->bindValue(':favgenre', $favgenre);
                $stmt->execute();
                $showform = 0;

                ##SEND EMAIL CODE
                $sqlse = "SELECT * FROM project_viewers WHERE vid = :ID";
                $stmt = $pdo->prepare($sqlse);
                $stmt->bindValue(':ID', $ID);
                $stmt->execute();
                $rowse = $stmt->fetch(PDO::FETCH_ASSOC);

                $Subject = "Profile Update";
                $Body = "<p style='color:salmon'>You have successfully updated your profile " . $rowse['uname'] . ".</p>";
                $AltBody = 'You have successfully updated your profile.';
                $email = $_SESSION['email'];
                $fname = $_SESSION['uname'];
                $EmailOkay = "You will be receiving a confirmation email for updating your profile.";
                $EmailFail = "An error occurred trying to send the email. The email did not send.";
                $sendEmail = sendEmail($Subject, $Body, $AltBody, $email, $fname);
            } else {
                echo "<p class='success'>You have successfully updated your profile information!!!</p>";
                $sql = "UPDATE project_viewers
        SET uname = :uname, email = :email, favgenre = :favgenre, file = :file
        WHERE vid = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':ID', $ID);
                $stmt->bindValue(':uname', $uname);
                $stmt->bindValue(':email', $email);
//                $stmt->bindValue(':passw', $hashed);
                $stmt->bindValue(':favgenre', $favgenre);
                $stmt->bindValue(':file', $userfile);
                $stmt->execute();
                $showform = 0;


                ##SEND EMAIL CODE
                $sqlse = "SELECT * FROM project_viewers WHERE vid = :ID";
                $stmt = $pdo->prepare($sqlse);
                $stmt->bindValue(':ID', $ID);
                $stmt->execute();
                $rowse = $stmt->fetch(PDO::FETCH_ASSOC);

                $Subject = "Profile Update";
                $Body = "<p style='color:salmon'>You have successfully updated your profile " . $rowse['uname'] . ".</p>";
                $AltBody = 'You have successfully updated your profile.';
                $email = $_SESSION['email'];
                $fname = $_SESSION['uname'];
                $EmailOkay = "You will be receiving a confirmation email for updating your profile.";
                $EmailFail = "An error occurred trying to send the email. The email did not send.";
                $sendEmail = sendEmail($Subject, $Body, $AltBody, $email, $fname);
            }

        }
}// closing of if server method is post

//    print_r($ID);
//    ?><!--<br>--><?php
//    print_r($showform);

##USER FORM FIELD CODE
if ($showform == 1) {

    //query the database to populate the form
    $sql = "SELECT * from project_viewers WHERE vid = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $ID);
    $stmt->execute();
    $row = $stmt->fetch();
    ?>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">

        <!-- Username code -->
        <?php
        if (isset($unameerr)) {
            echo $unameerr;
        }
        ?>
        <label for="uname">What is your username? </label>
        <input type="text" name="uname" id="uname" placeholder="Username" value="<?php if(isset($row['uname'])){ echo htmlspecialchars($row['uname']);}?>"><br><br>

        <!-- Email code -->
        <?php
        if (isset($emailerr)) {
            echo $emailerr;
        }
        ?>
        <label for="email">What is your email? </label>
        <input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($row['email'])){ echo htmlspecialchars($row['email']);}?>"><br>



        <!-- Favorite Genre code -->
        <?php
        if (isset($favgenreerr)) {
            echo $favgenreerr;
        }

        /*
        $sql = "SELECT DISTINCT genre FROM project_movies
    INNER JOIN project_viewers ON project_movies.genre = project_viewers.favgenre 
    WHERE vid = :vid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':vid', $_SESSION['ID']);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        */

        $sqlr = "SELECT DISTINCT genre FROM project_movies";
        $stmt = $pdo->prepare($sqlr);
        $stmt->execute();
        $resultr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <br><label for="favgenre">Which genre is your favorite </label><select name="favgenre" id="favgenre">
            <?php foreach ($resultr as $row) { ?>
                <option value="<?php echo $row['genre'];  // gives the value?>"
                    <?php if (isset($favgenre) && $favgenre == $row['genre']) { echo " selected ";}?>>
                    <?php echo $row['genre']; // list all genres in the dropdown box?></option>
                <?php
            } // end of foreach
            ?>
        </select><br><br>

        <!-- File code -->
        <?php if (!empty($fileerr)) {echo "<p class='error'>" . $fileerr . "</p>";}?>
        <label for="file">Upload Your Profile Picture:</label><input type="file" name="file" id="file"><br><br>


        <!-- Submit code -->
        <label for="submit">Update:  </label><input type="submit" name="submit" id="submit" value="update"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
}
require_once "footer.php";
?>

