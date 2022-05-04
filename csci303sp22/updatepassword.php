<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Update Password";
require_once "header.php";

if (isset($_SESSION['ID'])) {
$ID = $_SESSION['UID'];
$showform = 1;

##ERROR VARIABLES
$errmsg = 0;
$passwerr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form?><br><?php
    #print_r($_FILES);


    ##LOCAL VARIABLES
    $passw = $_POST['passw'];

    ##LOCAL VARIABLES ERROR CHECKING
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

    ##CONTROL CODE
    if ($errmsg != 0) {
        //Provide a message to the user that there are errors.
        echo "<p class='error'>You have made an error(s). Please fix them.</p>";
    } else {
        //Write the code for what to do when there are no errors AND provide a success message (or other instructions) for the user.
        echo "<p class='success'>Thank you! You have successfully created an account! Please sign in.</p>";
        //INSERT CODE
        $sql = "UPDATE project_viewers SET passw = :passw WHERE vid = :vid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':vid', $ID);
        $stmt->bindValue(':passw', $hashed);
        $stmt->execute();
        $showform = 0; //Hide the form

        ##SEND EMAIL CODE
        $sqlse = "SELECT * FROM project_viewers WHERE vid = :ID";
        $stmt = $pdo->prepare($sqlse);
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();
        $rowse = $stmt->fetch(PDO::FETCH_ASSOC);

        $Subject = "Password Reset";
        $Body = "<p style='color:salmon'>You have successfully updated your password " . $rowse['uname'] . ".</p>";
        $AltBody = 'You have successfully updated your password.';
        $email = $_SESSION['email'];
        $fname = $_SESSION['uname'];
        $EmailOkay = "You will be receiving a confirmation email for updating your password.";
        $EmailFail = "An error occurred trying to send the email. The email did not send.";
        $sendEmail = sendEmail($Subject, $Body, $AltBody, $email, $fname);

        //REDIRECT TO CONFIRMATION PAGE
        header("Location: movieconfirm.php?state=3");
    }
}// closing of if server method is post

##FORM FIELD CODE
if ($showform == 1)
{
    ?>
    <p> ** All Fields are required except where stated otherwise. ** </p>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">

    <!-- Password code -->
        <?php
        if (isset($passwerr)) {
            echo $passwerr;
        }
        ?>
        <br><label for="passw">What is your password? (Must be at least 8 Characters) </label>
        <input type="text" name="passw" id="passw" placeholder="Password" value="<?php if(isset($_SESSION['passw'])){ }?>"><br><br>


    <!-- Submit code -->
        <label for="submit">Submit  </label><input type="submit" name="submit" id="submit" value="submit"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
}
require_once "footer.php";
?>

