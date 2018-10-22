<?php
session_start();
require_once '../../config.php';

// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
 $year = date("Y");
    $f_year = mysql_query("SELECT year,church_id FROM financial_year WHERE year='$year' AND church_id=" . $_SESSION['church']);
    if (mysql_num_rows($f_year) == 0) {
       $church_id = $_SESSION['church'];
        
        $query_insert = mysql_query("INSERT INTO financial_year(year,church_id) VALUES ('$year','$church_id')");
        if ($query_insert) {
          
            echo 'Successfully started new year';
        }
       }
  