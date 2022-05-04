<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/
// COPY ALL OF THE CODE ON THIS PAGE AND PASTE IT AFTER YOUR AUTO-GENERATED, INITIAL COMMENTS
// DO NOT DELETE ANY COMMENTS.  USE THEM AS A GUIDE FOR WHERE TO PLACE CODE.
// WRITE YOUR CODE UNDER THE COMMENTS AS INDICATED.

/* ************************************************************************
    PAGE SETUP
    The next two lines of code would be used to setup the page structure.
************************************************************************ */

//Populate the page name variable for use in header code.
$pagename = "Insert";

//Include the header file with require_once
require_once "header.php";

/* ************************************************************************
    INITITAL VARIABLES
        In this section, we create the flag to show the form or not, and whether or not we have errors.
        We also create unique variables to store error messages for each form field we evaluate.
************************************************************************ */

// Create a flag to determine whether to show the form or not.  Required to use the $showform variable with either 1 (or modify for TRUE).
$showform = 1;

// ON THE NEXT LINE:  Create a general-purpose error flag that is used to determine if there are any errors or not.  Example:  $err = 0; (or FALSE)
$errmsg = 0;

// ON THE NEXT LINE:  Create individual error variables (set to empty strings) for all form fields to store specific messages.  Example:  $errmyvar = "";
$emailerr = "";
$passworderr = "";
$colorerr = "";
$favstateerr = "";
$hobbieserr = "";

/* ************************************************************************
    FORM PROCESSING
        Create a block of code in which all of the form processing is performed.
        The IF statement checks to see if the request method is post (the form is submitted)
        Everything from error checking to processing data is in this block of code.  The form is hidden upon success.
************************************************************************ */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    print_r($_POST);  #Displays contents of form

    /* ************************************************************************
    	LOCAL VARIABLES / SANTIZE USER DATA
    	    Create local variables to store data collected by the form.  Some user data will be modified.
    	    Some user inputs do not need modifications such as textarea data and passwords.  Example:
               $somepassword = $_POST['somepassword'];
    	    Trim all "input type" fields where users type freely (except passwords).  Example:
               $somefirstname = trim($_POST['somefirstname']);
            In this course, we'll ALWAYS use strtolower for emails, URLs, and usernames.  Example:
                    $someemailorurl = trim(strtolower($_POST['someemailorurl']));
    ************************************************************************ */

    //Create all of the required local variables and sanitize only where necessary.
    $email = trim(strtolower($_POST['email']));
    $password = $_POST['password'];
    if (isset($_POST['color'])) {
        $color = $_POST['color'];
    }
    $favstate = $_POST['favstate'];
    $hobbies = $_POST['hobbies'];

    /* ************************************************************************
        ERROR CHECKING
        In this section, you’re checking for all errors that would prevent you from wanting to continue processing the form.
        For each error you find, you update the general error flag.  Example: $err = 1; or TRUE instead instead of 0 or FALSE.
        For each error you find, update the specific error variable with a message for the user.
        For all required fields, you are checking to see if they are empty or not.
    ************************************************************************ */

    //Write the code to check for errors for each of your form fields
    #$url checking
    if (empty($email)) { #Check if url/email is empty
        $errmsg = 1;
        $emailerr = "<span class='error'> Email is missing!! </span><br>";
    } else { #Check if url/email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $emailerr = "<span class='error'>This is not a valid email address!!</span><br>";
        } else {
            $sql = "SELECT * FROM users WHERE email = :field";
            $emailexists = check_duplicates($pdo, $sql, $email);
            if ($emailexists) {
                $errmsg = 1;
                $emailerr .= "<span class='error'> This email is already taken.</span>";
            }
        }
    }

    #password checking
    if (empty($password)){ #Check if user input is empty
        $errmsg = 1;
        $passworderr = "<span class='error'> Your password is missing!! </span>";
    } else {
        if (strlen($password) < 10) { #Check if user input is valid
            $errmsg = 1;
            $passworderr = "<span class='error'> Not enough characters in password!! </span><br>";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
        }
    }


    #Radio checking
    if (!isset($_POST['color'])) { #Check if radio input is empty
       $errmsg = 1;
       $colorerr = "<span class='error'> You did not select a color!! </span>";
    }


    #Select checking
    if (empty($favstate)) { #Check if select input is empty
        $errmsg = 1;
        $favstateerr = "<span class='error'>You haven't picked your favorite state!!</span><br>";
    }


    #Text area checking
    if (empty($hobbies)) { #Check if text area input is empty
        $errmsg = 1;
        $hobbieserr = "<span class='error'>You did not write about any hobbies!!</span>";
    }

    /* ************************************************************************
    CONTROL CODE
        This controls the flow of the program.
        It determines what to do if there are or are not errors.
    ************************************************************************ */

    if ($errmsg != 0) {
        //Provide a message to the user that there are errors.
        echo "<p class='error'>You have made an error(s). Please fix them.</p><br>";
    } else {
        //Write the code for what to do when there are no errors AND provide a success message (or other instructions) for the user.
        echo "<p class='success'>Great job! You have entered all in all your information.</p>";
        //INSERT CODE
        $sql = "INSERT INTO users (email, password, color, favstate, hobbies) VALUES (:email, :password, :color, :favstate, :hobbies)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashed);
        $stmt->bindValue(':color', $color);
        $stmt->bindValue(':favstate', $favstate);
        $stmt->bindValue(':hobbies', $hobbies);
        $stmt->execute();
        $showform = 0; //Hide the form
    }
}// closing of if server method is post

/* ************************************************************************
    THE FORM
        The ENTIRE form goes into a block of code.
        The closing curly brace for the if statement is AFTER the form in a block of PHP code
************************************************************************ */
if ($showform == 1)
{
    ?>
    <p>All Fields are required.</p>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>">

    <!-- Email code -->
        <?php
        if (isset($emailerr)) {
            echo $emailerr;
        }
        ?>
        <label for="email">What is your email? </label>
        <input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($email)){ echo htmlspecialchars($email);}?>"><br><br>

    <!-- Username code -->
        <?php
        if (isset($passworderr)) {
            echo $passworderr;
        }
        ?>
        <br><label for="password">What is your password? (Must be at least 10 Characters) </label>
        <input type="text" name="password" id="password" placeholder="Password" value="<?php if(isset($password)){ echo htmlspecialchars($password);}?>"><br><br>

    <!-- Favorite Color code -->
        <?php
        if (isset($colorerr)) {
            echo $colorerr;
        }
        ?>
        <p>What's your favorite color of these three?</p>
        <input type="radio" name="color" id="color0" value="R"
            <?php if (isset($color) && $color == "R") {echo " CHECKED ";}?>>
        <label for="color0">Red</label><br>

        <input type="radio" name="color" id="color1" value="G"
            <?php if (isset($color) && $color == "G") {echo " CHECKED ";}?>>
        <label for="color1">Green</label><br>

        <input type="radio" name="color" id="color2" value="B"
            <?php if (isset($color) && $color == "B") {echo " CHECKED ";}?>>
        <label for="color2">Blue</label><br><br>

    <!-- Favorite State code -->
        <?php
        if (isset($favstateerr)) {
            echo $favstateerr;
        }
        $sql = "SELECT statename, abbrev FROM statelist";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="favstate">Which state do you like more: </label><select name="favstate" id="favstate">
            <?php foreach ($result as $row) { ?>
                <option value="<?php echo $row['abbrev'];  // gives abbrev foreach statename?>"
                <?php if (isset($favstate) && $favstate == "") { echo " selected ";}  // repopulates value if submit is hit?>>
                    <?php echo $row['statename']; // list all states ?></option>
            <?php
            } // end of foreach
            ?>
        </select><br><br>

    <!-- Hobbies code -->
        <?php
        if (isset($hobbieserr)) {
            echo $hobbieserr;
        }
        ?>
       <br> <label for="hobbies">What are your hobbies?</label><br>
        <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
        <textarea name="hobbies" id="hobbies" rows="3" cols="20"><?php if (isset($hobbies)) { echo $hobbies; }?></textarea><br><br>

    <!-- Submit code -->
        <label for="submit">Submit  </label><input type="submit" name="submit" id="submit" value="submit"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
require_once "footer.php";
?>