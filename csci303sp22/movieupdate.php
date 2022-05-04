<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/25/2022
  * Time:  12:31 PM
*/

$pagename = "Updating Movielist";
require_once "header.php";

$showform = 1;

##ERROR VARIABLES
$errmsg = 0;
$mnameerr = "";
$genreerr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    #print_r($_POST);  #Displays contents of form?><br><?php
    #print_r($_FILES);

    ##LOCAL VARIABLES
    $mname = $_POST['mname'];
    $genre = $_POST['genre'];

    ##ERROR CHECKING
    #Movie name checking
    if (empty($mname)) { #Check if movie name is empty
        $errmsg = 1;
        $mnameerr = "<span class='error'> The movie title is missing!! </span><br>";
    } else {
        if (strlen($mname) > 50) { #Check if number of characters is valid
            $errmsg = 1;
            $mnameerr = "<span class='error'> The movie title is too long!! </span><br>";
        } else {
            ##CHECK FOR DUPLICATES
            $sql = "SELECT * FROM project_movies WHERE mname = :field";
            $mnameexists = check_duplicates($pdo, $sql, $mname);
            if ($mnameexists) {
                $errmsg = 1;
                $mnameerr .= "<span class='error'> This movie is already in the list.</span><br>";
            }
        }
    }

    #Genre checking
    if (empty($genre)) { #Check if genre is empty
        $errmsg = 1;
        $genreerr = "<span class='error'> The movie genre is missing!! </span><br>";
    } else {
        if (strlen($genre) > 20) { #Check if number of characters is valid
            $errmsg = 1;
            $genreerr = "<span class='error'> There are too many characters for the genre!! </span><br>";
        }
    }

    ##CONTROL CODE
    if ($errmsg != 0) {
        //Provide a message to the user that there are errors.
        echo "<p class='error'>You have made an error(s). Please fix them.</p>";
    } else {
        //Write the code for what to do when there are no errors AND provide a success message (or other instructions) for the user.
        echo "<p class='success'>You have successfully updated the movie list</p>";
        //INSERT CODE
        $sql = "INSERT INTO project_movies (mname, genre) VALUES (:mname, :genre)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mname', $mname);
        $stmt->bindValue(':genre', $genre);
        $stmt->execute();
        $showform = 0; //Hide the form

        #CREATE SESSION VARIABLE
        $sql = "SELECT * FROM project_movies WHERE mname = :mname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mname', $mname);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['mname'] = $mname;

        #CHANGE LOCATION
        header("Location: movielist.php?");
        }
}// closing of if server method is post

##FORM FIELD CODE
if ($showform == 1)
{
    ?>
    <p> ** Both Fields are required. ** </p>
    <form name="myform" id="WilliamAdams" method="post" action="<?php echo $currentfile;?>" enctype="multipart/form-data">

        <!-- Movie Name code -->
        <?php
        if (isset($mnameerr)) {
            echo $mnameerr;
        }
        ?>
        <label for="mname">What is the movie's name? </label>
        <input type="text" name="mname" id="mname" placeholder="Movie Name" value="<?php if(isset($mname)){ echo htmlspecialchars($mname);}?>"><br><br>

        <!-- Genre code -->
        <?php
        if (isset($genreerr)) {
            echo $genreerr;
        }
        ?>
        <label for="genre">What is the movie's genre? </label>
        <input type="text" name="genre" id="genre" placeholder="Genre" value="<?php if(isset($genre)){ echo htmlspecialchars($genre);}?>"><br><br>


        <!-- Submit code -->
        <label for="submit">Update:  </label><input type="submit" name="submit" id="submit" value="update"><br><br>
    </form>
    <?php
} //Closes the if statement for showform
require_once "footer.php";
?>

