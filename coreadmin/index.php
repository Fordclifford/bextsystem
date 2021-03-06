<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get DB instance. function is defined in config.php
$db = getDbInstance();
//Get Dashboard information
$numChurches = $db->getValue ("church", "count(*)");
if($_SESSION['user_type']== 'auditor'){
   $db->where("user_id",$_SESSION['user_logged_in']);
   $row = $db->get('conference');
   $db = getDbInstance();
   $db->where("conf_id",$row[0]['id']);
   $numChurches = $db->getValue ("church", "count(*)");
  }
$numConf = $db->getValue ("conference", "count(*)");
  if($_SESSION['user_type']== 'union_auditor'){
 
   $db->where("user_id",$_SESSION['user_logged_in']);
   $row = $db->get('union_mission');
   $db = getDbInstance();
   $db->where("union_id",$row[0]['id']);
   $numConf = $db->getValue ("conference", "count(*)");
   $db->where("union_id",$row[0]['id']);
   $numChurches = $db->getValue ("church", "count(*)");
  }
  
$numUsers = $db->getValue ("users", "count(*)");
$numUnion = $db->getValue ("union_mission", "count(*)");

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
       
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-globe fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numChurches; ?></div>
                            <div>Churches </div>
                        </div>
                    </div>
                </div>
                <a href="churches.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
         <div class="col-lg-3 col-md-6">
             <?php if ($_SESSION['user_type']== 'admin' || $_SESSION['user_type']== 'super')  : ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numUsers; ?></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <a href="admin_users.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Users</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
              <?php endif;
            ?>
        </div>
        <div class="col-lg-3 col-md-6">

        </div>
        <div class="col-lg-3 col-md-6">

        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
              <?php if ($_SESSION['user_type']== 'admin' || $_SESSION['user_type']== 'super' || $_SESSION['user_type']== 'union_auditor')  : ?>
       
          <div class="panel panel-red">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-user fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge"><?php echo $numConf; ?></div>
                          <div>Conferences</div>
                      </div>
                  </div>
              </div>
              <a href="conferences.php">
                  <div class="panel-footer">
                      <span class="pull-left">View Conferences</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
             <?php endif;
            ?>
        </div>

      <div class="col-lg-3 col-md-6">
          <?php if ($_SESSION['user_type']== 'admin' || $_SESSION['user_type']== 'super' )  : ?>
          <div class="panel panel-yellow">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-user fa-5x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <div class="huge"><?php echo $numUnion; ?></div>
                          <div>Unions</div>
                      </div>
                  </div>
              </div>
              <a href="unions.php">
                  <div class="panel-footer">
                      <span class="pull-left">View Unions</span>
                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>
            <?php endif;
            ?>
      </div>
        <!-- /.col-lg-8 -->
        
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->




<?php include_once('includes/footer.php'); ?>
