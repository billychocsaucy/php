<?php
$pagename = "SendEmail";
require_once "header.php";
/* ***********************************************************************
 * MODIFY THE FOLLOWING VARIABLE VALUES
 * ********************************************************************** */
// 1 - Subject
$Subject = "Put Your Email Subject Here";
// 2 - Body of email - See how you can add HTML?  See how I added a little style?  MODIFY!
$Body = "<p style='color:purple'>Put the body of your message here.</p>";
// 3 - Alt Body - Body of email without HTML
$AltBody = 'Put the body of your message here but without HTML markup';
// 4 - You need a variable called $email for the email recipient.  This should already be created in your form.
$email = "wjadams@coastal.edu";
// 5 - You need a variable called $first_name that will have the first name of the person receiving the email
$fname= "William";
// 6 - Success Message to the user - You can modify to have a span tag and a success class.
$EmailOkay = "TESTModify this success message to let the user know they will be receiving an email.";
// 7 - Error Message to the user - You can modify to have a span tag and an error class.
$EmailFail = "Modify this error message to let the user know there was a problem sending.";

/* ***********************************************************************
 * DO NOT MAKE CHANGES BELOW THIS LINE!
 * ********************************************************************** */
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
$sendEmail = sendEmail($Subject, $Body, $AltBody, $email, $fname);
//send the message, check for errors
if ($sendEmail == 1) {
    echo $EmailOkay;
} else {
    echo $EmailFail;
}

require_once "footer.php";