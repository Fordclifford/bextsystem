<?php
require_once './coreadmin/config/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = filter_input(INPUT_POST, 'username');
    $passwd = filter_input(INPUT_POST, 'passwd');
    $remember = filter_input(INPUT_POST, 'remember');
    $user_type = filter_input(INPUT_POST, 'user_type');
    $passwd=  md5($passwd);
//$users=array("super","auditor","admin");
    //Get DB instance. function is defined in config.php
    if ($user_type=="treasurer"){
    $db = getDbInstance();
    $db->where ("user_name", $username);
    $db->where ("passwd", $passwd);
    $db->where("user_type", "treasurer");
  $row = $db->get('users');
      if ($db->count >= 1) {
        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['user_type'] = $row[0]['user_type'];
        $db = getDbInstance();
       $_SESSION['user_logged_in'];
        $db->where("user_id",  $_SESSION['user_logged_in']);
        $row = $db->get('church');
        $_SESSION['church'] = $row[0]['id'];
       	if($remember)
       	{
       		setcookie('username',$username , time() + (86400 * 90), "/");
       		setcookie('password',$passwd , time() + (86400 * 90), "/");
       	}
        header('Location:index.php');
        exit;
    }
    } 
    if ($user_type!="treasurer"){
        
     $db = getDbInstance();
    $db->where ("user_name", $username);
    $db->where ("passwd", $passwd);
    $db->where("user_type", ["super","auditor","admin"], 'IN');
  $row = $db->get('users');
      if ($db->count >= 1) {
        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['user_type'] = $row[0]['user_type'];
       
       	if($remember)
       	{
       		setcookie('username',$username , time() + (86400 * 90), "/");
       		setcookie('password',$passwd , time() + (86400 * 90), "/");
       	}
        header('Location:coreadmin/index.php');
        exit;
    } 
        
    }
    
    else {
        $_SESSION['login_failure'] = "Invalid credentials";
        header('Location:login.php');
        exit;
    }
}

