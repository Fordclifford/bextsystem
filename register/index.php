<?php
if (isset($_SESSION['user_logged_in']) != "") {
    header("Location: ../index.php");
}
require_once './config.php';

$query = "SELECT id,union_name FROM union_mission";
$stmt = $DB->prepare($query);
$stmt->execute();

foreach ($stmt->fetchAll() as $row) {
    $unions[] = array("id" => $row['id'], "val" => $row['union_name']);
}
$query = "SELECT id, union_id,conf_name FROM conference";
$stmt = $DB->prepare($query);
$stmt->execute();

foreach ($stmt->fetchAll() as $row) {
    $conferences[$row['union_id']][] = array("id" => $row['id'], "val" => $row['conf_name']);
}
$jsonUnions = json_encode($unions);
$jsonConferences = json_encode($conferences);


require_once('header.php');
?>
<body onload='loadUnions()'>
<div class="container-fluid">
   <div class="row">
       <img height="200px" width="1500px" src="../assets/image/header3.png"  border="0" alt="Main Banner">
   </div>
</div>
       
    <div id="wrapper">

        <div>
            <div class="row">
                <div class="text-center">
                    <h1 style="font-size: 22px;"><i class="glyphicon glyphicon-registration-mark"></i> Register Church</h1>
                </div>
            </div>

            <div >
                <?php if ($msg <> "") { ?>
                    <div class="alert alert-dismissable alert-<?php echo $msgType; ?>">
                        <button data-dismiss="alert" class="close" onclick="this.parentElement.style.display = 'none';" type="button">x</button>
                        <p><?php echo $msg; ?></p>
                    </div>
                <?php } ?>

                <form id="register_church" class="well form-horizontal" autocomplete="off"  enctype="multipart/form-data">
                    <?php include_once('./forms/register_form.php'); ?>
                </form>
            </div>
        </div>
    <div class="loader">
   <center>
       <img class="loading-image" src="../assets/image/demo_wait.gif" alt="loading..">
   </center>
</div>
    </div>



    <?php include 'footer.php'; ?>
