<?php
session_start();
require_once './coreadmin/config/config.php';
require_once 'includes/auth_validate.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     $data_to_store = filter_input_array(INPUT_POST);
   $data_to_store['sender']=$_SESSION['user_logged_in'];    
    $db = getDbInstance();
    $last_id = $db->insert ('comments', $data_to_store);
        if($last_id)
    {
    	$_SESSION['success'] = "Message sent successfully!";
  
    }
  
}
include_once'includes/header.php'
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true ) : ?>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Income & Expense Tracker</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->

                <!-- /.dropdown -->
    <li> <a id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span><i class="fa fa-envelope fa-fw"></i></a>
<div id="notification-latest"></div>
</li>


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>

                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

   <div class="navbar-default sidebar" role="navigation">
                            <div class="sidebar-nav navbar-collapse">
                                <ul class="nav" id="side-menu">
                                    <li>
                                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                    </li>

                                    <li>
                                        <a href="bills.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Bills<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="bills.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                            </li>
                                        <li>
                                            <a href="addbill.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                        </li>
                                        </ul>
                                    </li>
                                    
                                    <li >
                                        <a href="budget.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Budget<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="income.php"><i class="fa fa-list fa-fw"></i>Estimated Income</a>
                                            </li>
                                        <li>
                                            <a href="expenses.php"><i class="fa fa-plus fa-fw"></i>Estimated Expenses</a>
                                            <ul class="nav nav-second-level">
                                                
</ul>
                                        </li>
                                        </ul>
                                    </li>

                                    <li>
                                           <a href="actual_income.php"> <i class="glyphicon glyphicon-usd"></i>Actual Income</a>

                                    </li>
                                    <li>
                                           <a href="balance.php"> <i class="glyphicon glyphicon-usd"></i> Balance</a>

                                    </li>
                                </ul>
                            </div>
                            <!-- /.sidebar-collapse -->
                        </div>
            <!-- /.navbar-static-side -->
        </nav>
    <?php endif; ?>

<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Notifications</h1>
        </div>
    </div>
<?php require_once 'includes/flash_messages.php'; ?>
        <form class="well form-horizontal" name="frmNotification" id="frmNotification" action="" method="post" >
            <fieldset>
            <div class="form-group">
                <div class="form-label"><label>Subject:</label></div><div class="error" id="subject"></div>
                <div class="input-group">
                    <input type="text" class="w3-round-large" name="subject" id="subject" style="height:35px;"required>
                        </div>
            </div>

            <div class="form-group">
                <label>Select Recipient: </label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user "></span></span>
                    <?php
                    $db->get('users');
                    echo "<select title=\" Choose User\" data-toggle=\"tooltip\"  style=\" height: 40px\" class=\" w3-round-large\" name=\"recipient\" id=\"recipient\" >";
                    echo "<option value=''> -----Select User------ </option>";
                    foreach ($db->get('users') as $row) {
                        echo "<option value='" . $row['id'] . "'>" . $row['user_name'] . "</option>";
                    } echo "</select>";
                    ?>

                </div>

            </div>
            <div class="form-group">
                <label>Comment:</label>
                <div class="input-group">
                    <textarea rows="4" cols="30" class="w3-round-large" name="comment" id="comment"></textarea>
                </div>
            </div>
          
            <div class="form-group">
                <div class="input-group">
                    <input type="submit" id="btn-send" value="Submit">
                </div>
            </div>
            </fieldset>
        </form>
    </div>
</div>


<?php include_once'includes/footer.php' ?>
