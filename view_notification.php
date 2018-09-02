<?php

session_start();
$conn = new mysqli("localhost", "root", "", "bext_system");

$sql = "UPDATE comments SET status=1 WHERE status=0";
$result = mysqli_query($conn, $sql);
$user = $_SESSION['user'];
$sq2 = "select * from comments where recipient=$user ORDER BY id DESC limit 5";
$result = mysqli_query($conn, $sq2);


$response = '';
while ($row = mysqli_fetch_array($result)) {
   $sender = $row['sender'];
    $sq3 = "select * from users where id=$sender";
     $result1 = mysqli_query($conn, $sq3);
while ($row1 = mysqli_fetch_array($result1)) {
    $response = $response . "<div class='notification-item' >" .
            "<div class='notification-subject'>" . $row1["user_name"] . "</div>" .
            "<div class='notification-comment'>" . $row["subject"] . "</div>" .
            "<div class='notification-comment'>" . $row["comment"] . "</div>" .
             "<div class='notification-comment'>" . $row["date"] . "</div>" .
            "</div>";
}
}
$response = $response . "<div class='notification-item view-all'>" . "<a class='view-all' href='notification.php'>" . "View All" . "</a>" . "</div>";

if (!empty($response)) {
    print $response;
}
?>
