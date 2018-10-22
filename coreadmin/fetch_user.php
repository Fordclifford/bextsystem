<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "bext_system");
$query = "SELECT * FROM users";
$result = mysqli_query($connect, $query);
$output = array();
while($row = mysqli_fetch_assoc($result))
{
 $output[] = $row;
}
echo json_encode($output);
?>
