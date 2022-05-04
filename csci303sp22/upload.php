<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  4/7/2022
  * Time:  11:39 AM
*/


//HEADER CODE ========================================================================================
$pagename = "Upload";
require_once "header.php";

//SET INITIAL VARIABLES ==============================================================================
$showform = 1;  // show form is true
$errmsg = 0; // inititally no errors
$errfile = ""; // initially no error

//FORM PROCESSING ====================================================================================
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // TROUBLE SHOOTING - DISPLAY CONTENTS OF $_FILES
    print_r($_FILES);
    echo "<br>";

    if ($_FILES['myfile']['error'] != 0) {
        $errmsg = 1;
        $errfile = "Error uploading file.";
    } else {
        /* **********************************************************************************
         * START HERE - SEE DIRECTIONS PART 1:  DISPLAY THE CONTENTS OF THE $_FILES ARRAY
         * ********************************************************************************** */
        echo "<h3>Part 1 - Contents of FILES Array</h3>";

        echo "<b>Name: </b>";
        print_r($_FILES['myfile']['name']);
        echo "<br><b>Type: </b>";
        print_r($_FILES['myfile']['type']);
        echo "<br><b>Temporary name: </b>";
        print_r($_FILES['myfile']['tmp_name']);
        echo "<br><b>Error: </b>";
        print_r($_FILES['myfile']['error']);

        /* **********************************************************************************
         * PART 2 - SEE DIRECTIONS PART 2:  USING PHP'S FILE INFORMATION FUNCTIONS
         * ********************************************************************************** */
        echo "<h3>Part 2 - File Information Functions</h3>";

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        echo "<strong>MIME Type: </strong>";
        echo finfo_file($finfo, $_FILES['myfile']['tmp_name']);
        finfo_close($finfo);

        /* **********************************************************************************
         * SEE DIRECTIONS PART 3:  USING THE PATHINFO FUNCTION
         * ********************************************************************************** */
        echo "<h3>Part 3 - Path Info Function</h3>";
        $pinfo = pathinfo($_FILES['myfile']['name']);
        print_r($pinfo);
        echo "<br><b>Directory name: </b>";
        echo $pinfo['dirname'];
        echo "<br><b>Basename: </b>";
        echo $pinfo['basename'];
        echo "<br><b>Extension: </b>";
        echo $pinfo['extension'];
        echo "<br><b>Filename: </b>";
        echo $pinfo['filename'];


        /* **********************************************************************************
         * SEE DIRECTIONS PART 4:  CREATE FILE NAME
         * ********************************************************************************** */
        echo "<h3>Part 4 - New Filename</h3>";
        $newfile = strtolower("wjadams" . $todaysdate->format('usiH') . "." . $pinfo['extension']);
        echo "<b>Myfile: </b>" . $newfile;

        /* **********************************************************************************
         * SEE DIRECTIONS PART 5:  CREATE A FILE PATH
         * ********************************************************************************** */
        echo "<h3>Part 5 - File Path</h3>";
        $filepath = "/var/www/html/uploads/" . $newfile;
        echo "<b>My File Path: </b>" . $filepath;


        /* **********************************************************************************
         * SEE DIRECTIONS PART 6:  CHECK EXISTING
         * ********************************************************************************** */
        if (file_exists($filepath)) {
            $errmsg = 1;
            $errfile = "File already exists.";
        } else {
            /* **********************************************************************************
             * SEE DIRECTIONS PART 7:  MOVING THE FILE
             * ********************************************************************************** */
            if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $filepath)) {
                $errmsg = 1;
                $errfile = "File cannot be moved.";
            }
        }//IF ALREADY EXISTS
    }//NO FILE ERROR
    // CONTROL CODE ===================================================================================
    if ($errmsg == 1) {
        echo "<p class='error'>Errors Exist!</p>";
    } else {
        echo "<p class='success'>Success!</p>";
        echo "<p>View your file: <a href='/uploads/" . $newfile . "' target='_blank''>" . $newfile . "</a></p>";
    } // else errorexists
}//submit

//DISPLAY FORM =======================================================================================
//REMEMBER TO CHANGE THE $currentfile VARIABLE NAME IF YOU USE A DIFFERENT NAME IN YOUR HEADER!
if ($showform == 1) {
    ?>
    <h3>Upload File Form</h3>
    <form name="upload" id="upload" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">
        <?php if (!empty($errfile)) {echo "<p class='error'>" . $errfile . "</p>";}?>
        <label for="myfile">Upload Your File:</label><input type="file" name="myfile" id="myfile">
        <br>
        <label for="submit">Submit:</label><input type="submit" name="submit" id="submit" value="UPLOAD">
    </form>
    <?php
}//end showform
$showform = 0;
//FOOTER CODE ========================================================================================
require_once "footer.php";
?>