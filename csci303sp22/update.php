
<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/31/2022
  * Time:  3:23 PM
*/

$pagename = "Update";
require_once "header.php";

//TRACKING THE ID
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $id = $_GET['q'];
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    echo "<p class='error'> Error has occurred!!!</p>";
    $errmsg = 1;
}

//INITIAL VARIABLES
$showform = 1;
$errmsg = 0;
$erremail = "";
$errpassword = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
//SANITIZE
    $email = trim(strtolower($_POST['email']));
    $password = $_POST['password'];
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
        } elseif ($email != $_POST['email']) {
            ##CHECK FOR DUPLICATES
            $sql = "SELECT * FROM users WHERE email = :field";
            $emailexists = check_duplicates($pdo, $sql, $email);
            if ($emailexists) {
                $errmsg = 1;
                $erremail .= "<span class='error'> This is already taken.</span>";
            }
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
            echo "<p class='success'>Thank you for entering in your information!!!</p>";
            $sql = "UPDATE users SET email = :email WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $showform = 0;
        }

//SHOWFORM
} if ($showform == 1) {

    //query the database to populate the form
    $sql = "SELECT * from users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch();

?>
    <p>All Fields Required</p>
    <form name="update" id="update" action="<?php echo $currentfile; ?>" method="post">

        <!-- EMAIL FIELD -->
        <label for="email">What is your Email </label><input type="email" id="email" name="email" placeholder="Enter Email"
            value="
            <?php
            if (isset($email)) {
                echo htmlspecialchars($email, ENT_QUOTES, "UTF-8");
            } else {
                echo htmlspecialchars($row['email'], ENT_QUOTES, "UTF-8");
            }?>">
        <?php
        if (!empty($erremail)) {
            echo "<span class='error'>$erremail</span>";
        }?>
        <br><br>

        <!-- PASSWORD FIELD -->
        <label for="password">What is your password? (Must be at least 8 Characters) </label>
        <input type="text" name="password" id="password" placeholder="Enter your Password"
               value="<?php if(isset($password)){ echo htmlspecialchars($password, ENT_QUOTES, "UTF-8");}
               else { echo htmlspecialchars($row['password'], ENT_QUOTES, "UTF-8"); }?>">
        <?php if (!empty($errpassword)) {echo "<span class='error'>$errpassword</span>";}?>
        <br><br>

        <!-- HIDDEN FIELDS -->
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"
        <input type="hidden" name="id" value="<?php echo $row['email']; ?>"

        <!-- SUBMIT FIELD -->
        <label for="submit">Submit: </label><input type="submit" id="submit" name="submit" value="submit">
    </form>
<?php
}

require_once "footer.php";
