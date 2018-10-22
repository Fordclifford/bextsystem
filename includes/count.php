<?php
require_once './coreadmin/config/config.php';
$count = 0;
$db = getDbInstance();
$recipient = $_SESSION['user_logged_in'];
$db->where ("recipient", $recipient);
$db->where ("status", 0);
  $row = $db->get('comments');
$count = $db->count >= 1;
