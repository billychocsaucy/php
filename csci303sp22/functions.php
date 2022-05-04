<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/23/2022
  * Time:  3:31 PM
*/

function check_duplicates($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field', $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}


//This function checks to see if someone is logged in
function checkLogin() {
    if (!isset($_SESSION['ID'])) {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.php";
        exit();
    }
}

//This function checks to see if the user logged in is an admin
function adminauth() {
    if (!isset($_SESSION['status']) && $_SESSION['status'] != 1) {
        echo "<p class='error'>You are not an admin. You do not have authorization.</p>";
        require_once "footer.php";
        exit();
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendEmail ($Subject, $Body, $AltBody, $email, $fname) {
    $mail = new PHPMailer(); //Create a new PHPMailer instance
    $mail->Host = 'smtp.gmail.com';//Set the hostname of the mail server
    $mail->SMTPAuth = true;//Whether to use SMTP authentication
    $mail->Username = 'ccucsciweb@gmail.com';//Username to use for SMTP auth - use full email address for gmail
    $mail->Password = 'csci303&409';//Password to use for SMTP authentication
    $mail->SMTPSecure = 'ssl';//Set the encryption
    $mail->Port = 465;//Set the SMTP port number
    $mail->Subject = $Subject;//Set the subject line
    $mail->isHTML(true);//Using HTML Email Body
    $mail->Body = $Body;//Set the Message Body
    $mail->AltBody = $AltBody;
    $mail->setFrom('ccucsciweb@gmail.com', 'CSCI 303 Email Account');//Set who the message is to be sent from
    $mail->addAddress($email, $fname);//Set who the message is to be sent to
    return $mail->send();
}