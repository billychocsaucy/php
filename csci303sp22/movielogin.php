<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/31/2022
  * Time:  10:37 AM
*/

$pagename = "Sign In";
require_once "header.php";

//INITIAL VARIABLES
$showform = 1;
$errmsg = 0;

$emailerr = "";
$passwerr = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
//SANITIZE
    $email = trim(strtolower($_POST['email']));
    $passw = ($_POST['passw']);
    $hashed = password_hash($passw, PASSWORD_DEFAULT);


//ERROR CHECKING
    //EMAIL ERROR CHECKING
    if (empty($email)) {
        $errmsg = 1;
        $emailerr = "You are missing an email";
    } else {
        ##VALIDATE EMAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errmsg = 1;
            $emailerr = "This email is not valid";
        }
    }

    //PASSWORD ERROR CHECKING
    if (empty($passw)) {
        $errmsg = 1;
        $passwerr = "You did not enter your password";
    } else {
        if (strlen($passw) < 8) {
            $errmsg = 1;
            $passwerr = "This password is too short";
        } else {
            $hashed = password_hash($passw, PASSWORD_DEFAULT);
        }
    }

//PROGRAM CONTROL
    if ($errmsg == 1) {
        echo "<p class='error'>Looks like you have errors!! Please Fix Them!!!</p>";
    } else {
        $sql = "SELECT * FROM project_viewers WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($email != $row['email']) {
            $errmsg = 1;
            $emailerr = "Your email is incorrect!!";
        } elseif (password_verify($passw, $row['passw'])) {
            //SET SESSION VARIABLES
            $_SESSION['ID'] = $row['vid'];
            $_SESSION['UID'] = $row['vid'];
            $_SESSION['uname'] = $row['uname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['passw'] = $passw;
            $_SESSION['favgenre'] = $row['favgenre'];
            $_SESSION['file'] = $row['file'];
            $_SESSION['status'] = $row['admin'];
            //REDIRECT TO CONFIRMATION PAGE
            header("Location: movieconfirm.php?state=2");
        } else {
            $errmsg = 1;
            $passwerr = "Your password is incorrect!!";
        }
    }

//SHOWFORM
} if ($showform == 1) {
    ?>
    <p>** If do not have an account yet please register **</p>
    <form name="authenication" id="authentication" action="<?php echo $currentfile; ?>" method="post">
        <!-- EMAIL FIELD -->
        <?php
        if (!empty($emailerr)) {
            echo "<span class='error'>$emailerr</span><br>";
        }
        ?>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" placeholder="Enter Email" value="<?php if (isset($email)) {echo htmlspecialchars($email);}?>">
        <br><br>

        <!-- PASSWORD FIELD -->
        <?php
        if (!empty($passwerr)) {
            echo "<span class='error'>$passwerr</span><br>";
        }
        ?>
        <label for="passw">Password: </label>
        <input type="text" name="passw" id="passw" placeholder="Enter your password" value="<?php if(isset($passw)){ echo htmlspecialchars($passw);}?>">
        <br><br>
        <!-- SUBMIT FIELD -->
        <input type="submit" id="submit" name="submit" value="Log In">
    </form>
    <?php
}

require_once "footer.php";