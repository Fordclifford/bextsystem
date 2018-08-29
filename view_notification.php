<?php
$conn = new mysqli("localhost","root","","bext_system");

$sql="UPDATE comments SET status=1 WHERE status=0";	
$result=mysqli_query($conn, $sql);

$sql="select * from comments ORDER BY id DESC limit 5";
$result=mysqli_query($conn, $sql);

$response='';
while($row=mysqli_fetch_array($result)) {
	$response = $response . "<div class='notification-item' >" .
	"<div class='notification-subject'>". $row["subject"] . "</div>" . 
	"<div class='notification-comment'>" . $row["comment"]  . "</div>".
	"</div>";
	
}	
$response=$response."<div class='notification-item view-all'>"  ."<a class='view-all' href='notification.php'>" ."View All"."</a>". "</div>";

	if(!empty($response)) {
	print $response;
}


?>