<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/31/2022
  * Time:  10:37 AM
*/

$pagename = "Log In";
require_once "header.php";

//INITIAL VARIABLES
$showform = 1;
$errmsg = 0;
$erremail = "";
$errpassword = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
//SANITIZE
    $email = trim(strtolower($_POST['email']));
    $password = ($_POST['password']);
    $hashed = password_hash($password, PASSWORD_DEFAULT);


//ERROR CHECKING
    //EMAIL ERROR CHECKING
    if (empty($email)) {
        $errmsg = 1;
        $erremail = "Missing Email";
    } else {
        ##VALIDATE EMAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $erremail = "This email is not valid";
        }
    }

    //PASSWORD ERROR CHECKING
    if (empty($password)) {
        $errmsg = 1;
        $errpassword = "You did not enter a password";
    } else {
        if (strlen($password) < 8) {
            $errmsg = 1;
            $errpassword = "This password is too short";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
        }
    }

//PROGRAM CONTROL
    if ($errmsg == 1) {
        echo "<p class='error'>Looks like you have errors!! Please Fix Them!!!</p>";
    } else {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $row['password'])) {
            //SET SESSION VARIABLES
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['status'] = $row['status'];
            //REDIRECT TO CONFIRMATION PAGE
            header("Location: confirm.php?state=2");
        } else {
            $errmsg = 1;
            $errpassword = "Your email or password is incorrect!";
        }
    }

//SHOWFORM
} if ($showform == 1) {
    ?>
    <p>Sign In</p>
    <form name="authenication" id="authentication" action="<?php echo $currentfile; ?>" method="post">
        <!-- EMAIL FIELD -->
        <label for="email">Email: </label><input type="email" id="email" name="email" placeholder="Enter Email"
            value="<?php if (isset($email)) {echo htmlspecialchars($email);}?>">
        <?php if (!empty($erremail)) {echo "<span class='error'>$erremail</span>";}?>
        <br><br>
        <!-- PASSWORD FIELD -->
        <label for="password">Password: </label>
        <input type="text" name="password" id="password" placeholder="Enter your Password"
               value="<?php if(isset($password)){ echo htmlspecialchars($password);}?>">
        <?php if (!empty($errpassword)) {echo "<span class='error'>$errpassword</span>";}?>
        <br><br>
        <!-- SUBMIT FIELD -->
        <label for="submit">Submit: </label><input type="submit" id="submit" name="submit" value="submit">
    </form>
    <?php
}

require_once "footer.php";