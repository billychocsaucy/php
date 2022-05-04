<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Movie Reviews Registration";
require_once "header.php";

$showform = 1;

##ERROR VARIABLES
$errmsg = 0;
$unameerr = "";
$emailerr = "";
$passwerr = "";
$favgenreerr = "";
$fileerr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form?><br><?php
    #print_r($_FILES);

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
    $passw = $_POST['passw'];
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
        } else { #Check for duplicates
            $sql = "SELECT * FROM project_viewers WHERE uname = :field";
            $unameexists = check_duplicates($pdo, $sql, $uname);
            if ($unameexists) {
                $errmsg = 1;
                $unameerr .= "<span class='error'> This username is already taken.</span>";
            }
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
        } else {
            $sql = "SELECT * FROM project_viewers WHERE email = :field";
            $emailexists = check_duplicates($pdo, $sql, $email);
            if ($emailexists) {
                $errmsg = 1;
                $emailerr .= "<span class='error'> This email is already taken.</span>";
            }
        }
    }

    #password checking
    if (empty($passw)){ #Check if user input is empty
        $errmsg = 1;
        $passwerr = "<br><span class='error'> You are missing a password!! </span>";
    } else {
        if (strlen($passw) < 8) { #Check if user input is valid
            $errmsg = 1;
            $passwerr = "<br><span class='error'> Not enough characters in password!! </span>";
        } else {
            $hashed = password_hash($passw, PASSWORD_DEFAULT);
        }
    }

    #Dropdown checking
    if ($favgenre == "PICK ONE") { #Check if select input is empty
        $errmsg = 1;
        $favgenreerr = "<span class='error'>You haven't picked your favorite genre!!</span><br>";
    }

    ##CONTROL CODE
    if ($errmsg != 0) {
        //Provide a message to the user that there are errors.
        echo "<p class='error'>You have made an error(s). Please fix them.</p>";
    } else {
        //Write the code for what to do when there are no errors AND provide a success message (or other instructions) for the user.
        echo "<p class='success'>Thank you! You have successfully created an account! Please sign in.</p>";
        //INSERT CODE
        if (empty($_FILES['file']['name'])) { #If upload file is empty
            $sql = "INSERT INTO project_viewers (uname, email, passw, favgenre) VALUES (:uname, :email, :passw, :favgenre)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':uname', $uname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':passw', $hashed);
            $stmt->bindValue(':favgenre', $favgenre);
            $stmt->execute();
            $showform = 0; //Hide the form
        }else { #If upload file is not empty
            $sql = "INSERT INTO project_viewers (uname, email, passw, favgenre, file) VALUES (:uname, :email, :passw, :favgenre, :file)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':uname', $uname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':passw', $hashed);
            $stmt->bindValue(':favgenre', $favgenre);
            $stmt->bindValue(':file', $userfile);
            $stmt->execute();
            $showform = 0; //Hide the form
        }
    }
}// closing of if server method is post

##FORM FIELD CODE
if ($showform == 1)
{
    ?>
    <p> ** All Fields are required except where stated otherwise. ** </p>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">

        <!-- Username code -->
        <?php
        if (isset($unameerr)) {
            echo $unameerr;
        }
        ?>
        <label for="uname">What is your username? </label>
        <input type="text" name="uname" id="uname" placeholder="Username" value="<?php if(isset($uname)){ echo htmlspecialchars($uname);}?>"><br><br>

        <!-- Email code -->
        <?php
        if (isset($emailerr)) {
            echo $emailerr;
        }
        ?>
        <label for="email">What is your email? </label>
        <input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($email)){ echo htmlspecialchars($email);}?>"><br>

    <!-- Password code -->
        <?php
        if (isset($passwerr)) {
            echo $passwerr;
        }
        ?>
        <br><label for="passw">What is your password? (Must be at least 8 Characters) </label>
        <input type="text" name="passw" id="passw" placeholder="Password" value="<?php if(isset($passw)){ echo htmlspecialchars($passw);}?>"><br><br>

        <!-- Favorite Genre code -->
        <?php
        if (isset($favgenreerr)) {
            echo $favgenreerr;
        }
        $sql = "SELECT DISTINCT genre FROM project_movies";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="favgenre">Which genre is your favorite </label><select name="favgenre" id="favgenre">
            <?php foreach ($result as $row) { ?>
                <option value="<?php echo $row['genre'];  // gives the value in the database?>"
                    <?php if (isset($favgenre) && $favgenre == $row['genre']) { echo " selected ";}  // repopulates value if submit is hit?>>
                    <?php echo $row['genre']; // list all genres in the dropdown box?></option>
                <?php
            } // end of foreach
            ?>
        </select><br><br>
        
    <!-- File code -->
        <p> ** OPTIONAL ** </p>
        <?php if (!empty($fileerr)) {echo "<p class='error'>" . $fileerr . "</p>";}?>
        <label for="file">Upload Your Profile Picture:</label><input type="file" name="file" id="file"><br><br>

    <!-- Submit code -->
        <label for="submit">Submit  </label><input type="submit" name="submit" id="submit" value="submit"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
require_once "footer.php";
?>

