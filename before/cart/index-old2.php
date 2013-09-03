<?php

// Show all URL parameters (and all form data submitted via the 'get' method)
/* foreach($_POST as $key=>$value){
	echo $key, ' => ', $value, "<br/>\n";
}
*/

// Show a particular value.
if $_POST["bundle"] {
echo "<p/>ID: ", $_POST["bundle"], "<br/>\n";
}
else {
	echo '<p>No ID parameter.</p>';
}
?>