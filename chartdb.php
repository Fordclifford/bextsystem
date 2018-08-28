<?php
/* Open connection to "zing_db" MySQL database. */
$mysqli = new mysqli("localhost", "root", "", "bext_system");

/* Check the connection. */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

<?php
/* Close the connection */


?>
