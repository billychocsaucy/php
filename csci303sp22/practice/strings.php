<?php

/*
  * Class:  csci303sp22
  * User:  wjadams
  * Date:  2/11/2022
  * Time:  1:05 PM
*/

// COPY ALL OF THE CODE ON THIS PAGE AFTER YOUR INITIAL COMMENTS
$pagename = "Strings";
require_once "../header.php"; //notice, looking UP one directory for this file.

/* ***********************************************************************
 * INTRODUCTION
 * We cover two types of strings (there are more)
 *  ***********************************************************************
*/
echo "<h3>Single and Double Quotes</h3>";
echo 'This is a string.';
echo "<br>";
echo "This is also a string.";
echo '<br>';

/* ***********************************************************************
 * Single & Double Together
 * ***********************************************************************
*/
echo "<h4>Single and Double Together</h4>\n";

echo "<a href='http://www.coastal.edu'>CCU</a>";

echo "<br>";

echo '<a href="http://www.coastal.edu">CCU</a>';

echo "<br>";

echo "<a href=\"http://www.coastal.edu\">CCU</a>";

echo "<br>";

echo '<a href=\'http://www.coastal.edu\'>CCU</a>';

echo "<hr>";


/* ***********************************************************************
 * The difference between single and double quotes
 * Using Variables
 * ***********************************************************************
*/
echo "I can put a new line \n to go on the next line.\n";
echo "<br>\n";
echo 'I can put a new line \n to go on the next line.';
echo "<hr>";

$var1 = "was";
$var2 = 20;
echo "<p>I am $var2!</p>";
echo '<p>I am $var2!</p>';
echo "<p>It $var1 my $var2 birthday!</p>";
echo '<p>It $var1 my $var2 birthday!</p>';

/* ***********************************************************************
 * CONCATENATION & OTHER EXAMPLES
 * ***********************************************************************
*/
echo "<h3>Concatenation</h3>";
echo "<p>I am " . $var2 . ".</p>";
echo '<p>I am ' . $var2 . '.</p>';

echo "<p>It " . $var1 . " my " . $var2 . "th birthday!</p>";
echo '<p>It ' . $var1 . ' my ' . $var2 . 'th birthday!</p>';

echo "<p>It $var1 my " . $var2 . "th birthday!</p>";
echo '<p>It $var1 my ' . $var2 . 'th birthday!</p>';

echo "<p>";
echo $var2 . " seems really old!";
echo "</p>";

echo '<p>';
echo $var2 . ' seems really old!';
echo '</p>';

echo "<h4>Concatenating Assignment Operator</h4>";
$err1 = "The password is too short. ";
echo $err1;
echo "<br>";
$err1 .= "The passwords do not match.";
echo $err1;
echo "<br>";
echo "<span class='error'>ERROR:  $err1</span>";
echo "<hr>";

?>
    <h3>HTML with PHP</h3>
    <p>I am <?php echo $var2; ?>.</p>
    <p>It <?php echo $var1; ?> my <?php echo $var2; ?>th birthday!</p>
    <p><?php echo $var2;?> seems really old!</p>

<?php
$term = "Chocolate";
?>

    <a href="https://www.google.com/search?q=<?php echo $term;?>" target="_blank">Search Chocolate</a>
    <br>
<?php
echo "<a href='https://www.google.com/search?q=$term' target='_blank'>Search Chocolate</a>";
echo "<br>";
echo '<a href="https://www.google.com/search?q=$term" target="_blank">Search Chocolate</a>';
echo "<hr>";

/* ***********************************************************************
 * Complex Syntax - Double Quotes
 * ***********************************************************************
*/
echo "<h3>Complex Syntax</h3>";
echo $_SERVER['PHP_SELF'];
echo "<br>";
echo "The path is {$_SERVER['PHP_SELF']}";
echo "<br>";
echo "The path is " . $_SERVER['PHP_SELF'];
echo "<br>";
echo 'The path is ' . $_SERVER['PHP_SELF'];
echo "<hr>";

require_once "../footer.php"; //notice, looking UP one directory for this file.