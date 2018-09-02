<?php
$count = 0;
$conn = new mysqli("localhost", "root", "", "bext_system");
$recipient = $_SESSION['user'];
$sql2 = "SELECT * FROM comments WHERE recipient=$recipient AND status = 0";
$result = mysqli_query($conn, $sql2);
$count = mysqli_num_rows($result);
mysqli_close($conn);
