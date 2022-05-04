<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  3/24/2022
  * Time:  11:04 AM
*/

$pagename = "Add";
require_once "../header.php";

$showform = 1;

$errmsg = 0;
$errexists = 0;

##Err Variables
$emp_noerr = "";
$fk_dept_noerr = "";
$birth_dateerr = "";
$first_nameerr = "";
$last_nameerr = "";
$gendererr = "";
$hire_dateerr = "";


##Local Variables
$emp_no = $_POST['emp_no'];
$fk_dept_no = $_POST['fk_dept_no'];
$birth_date = $_POST['birth_date']; ##date("o-m-d")
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$hire_date = $_POST['hire_date']; ##date("o-m-d")

##Error Checking
  ##emp_no
if (empty($emp_no)) {
    $errmsg = 1;
    $emp_noerr = "<span class='error'> Your employee number is missing!! </span>";
}

##fk_dept_no
if (empty($fk_dept_no)) {
    $errmsg = 1;
    $fk_dept_no = "<span class='error'> Your employee number is missing!! </span>";
}

##birth_date
if (empty($birth_date)) {
    $errmsg = 1;
    $birth_dateerr = "<span class='error'> Your employee number is missing!! </span>";
}

##first_name
if (empty($first_name)) {
    $errmsg = 1;
    $first_nameerr = "<span class='error'> Your employee number is missing!! </span>";
}
##last_name
if (empty($last_name)) {
    $errmsg = 1;
    $last_nameerr = "<span class='error'> Your employee number is missing!! </span>";
}
##gender
if (empty($gender)) {
    $errmsg = 1;
    $gender = "<span class='error'> Your employee number is missing!! </span>";
}
##hire_date
if (empty($hire_date)) {
    $errmsg = 1;
    $hire_dateerr = "<span class='error'> Your employee number is missing!! </span>";
}


##Form
if ($errexists == 1) {
    echo "<p class='error'>There are errors please check your form and resubmit again.</p>";
} else {
?>
    <form>

        <!-- emp_no -->
        <?php
        if (isset($emp_noerr)) {
            echo $emp_noerr;
        }
        ?>
        <label for="emp_no">What is your employee number? </label>
        <input type="text" id="emp_no" name="emp_no" value=""><br>

        <!-- fk_dept_no -->
        <?php
        if (isset($fk_dept_noerr)) {
            echo $fk_dept_noerr;
        }
        ?>
        <label for="fk_dept_no">What is your employee number? </label>
        <input type="text" id="fk_dept_no" name="fk_dept_no" value=""><br>

        <!-- birth_date -->
        <?php
        if (isset($birth_dateerr)) {
            echo $birth_dateerr;
        }
        ?>
        <label for="birth_date">What is your employee number? </label>
        <input type="text" id="birth_date" name="birth_date" value=""><br>

        <!-- first_name -->
        <?php
        if (isset($first_nameerr)) {
            echo $first_nameerr;
        }
        ?>
        <label for="first_name">What is your employee number? </label>
        <input type="text" id="first_name" name="first_name" value=""><br>

        <!-- last_name -->
        <?php
        if (isset($emp_noerr)) {
            echo $emp_noerr;
        }
        ?>
        <label for="emp_no">What is your employee number? </label>
        <input type="text" id="emp_no" name="emp_no" value=""><br>

        <!-- emp_no -->
        <?php
        if (isset($emp_noerr)) {
            echo $emp_noerr;
        }
        ?>
        <label for="emp_no">What is your employee number? </label>
        <input type="text" id="emp_no" name="emp_no" value=""><br>

        <!-- emp_no -->
        <?php
        if (isset($emp_noerr)) {
            echo $emp_noerr;
        }
        ?>
        <label for="emp_no">What is your employee number? </label>
        <input type="text" id="emp_no" name="emp_no" value=""><br>


        <label for="Submit">Submit</label><submit type="submit" id="submit" name="submit" value="submit">Submit</submit>
    </form>
<?php
    $showform = 0;
    if ($showform = 0) {
        echo "<p class='success'>Thank you for entering in your information!</p>";
    } ##if end
} ##errexist else end


require_once "../footer.php";