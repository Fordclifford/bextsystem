<?php
session_start();
require_once './coreadmin/config/config.php';
require_once 'includes/auth_validate.php';

$db = getDbInstance();
$data = Array("status" => 1);      
$db->where('status',0);
$db->update('comments', $data);


$db = getDbInstance();
$user = $_SESSION['user_logged_in'];
$db->where('recipient',$user);
$db->orderBy('id', 'DESC');



$response = '';
foreach ($db->get('comments',5) as $row ) {
   $sender = $row['recipient'];
   $db->where('id',$sender);
foreach ($db->get('users') as $row1 ) {
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
