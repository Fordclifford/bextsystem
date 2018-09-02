<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bext_system");
if (!empty($_POST['add'])) {
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $sender = $_SESSION['user'];
    $recipient = mysqli_real_escape_string($conn, $_POST["recipient"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $sql = "INSERT INTO comments (subject,comment,sender,recipient) VALUES('" . $subject . "','" . $comment . "','" . $sender . "','" . $recipient . "')";
    mysqli_query($conn, $sql);
}
include_once'includes/header.php'
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php if (isset($_SESSION['user']) && $_SESSION['user'] == true ) : ?>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">B&E Tracker</a>
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
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <li <?php echo (CURRENT_PAGE =="balance.php" || CURRENT_PAGE=="balance.php") ? 'class="active"' : '' ; ?>>
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
                        <li>
                           <a href="expenses.php"> <i class="glyphicon glyphicon-apple"></i> Expenses</a>
                        </li>
                         <li>
                           <a href="budget.php"> <i class="glyphicon glyphicon-usd"></i> Budget</a>
                        </li>

                        <li>
                               <a href="income.php"> <i class="glyphicon glyphicon-usd"></i> Income</a>

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
    <div class="demo-content">

        <?php if (isset($message)) { ?> <div class="error"><?php echo $message; ?></div> <?php } ?>


        <?php if (isset($success)) { ?> <div class="success"><?php echo $success; ?></div> <?php } ?>

        <form name="frmNotification" id="frmNotification" action="" method="post" >

            <div class="form-group">
                <div class="form-label"><label>Subject:</label></div><div class="error" id="subject"></div>
                <div class="input-group">
                    <input type="text"  name="subject" id="subject" style="height:35px;"required>
                        </div>
            </div>

            <div class="form-group">
                <label>Select Recipient: </label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user "></span></span>
                    <?php
                    include_once 'config.php';
                      $sqls = "Select * FROM users ";
                    $qs = mysql_query($sqls);
                    echo "<select title=\" Choose User\" data-toggle=\"tooltip\"  style=\" height: 40px\" class=\" w3-round-large\" name=\"recipient\" id=\"recipient\" >";
                    echo "<option value=''> -----Select User------ </option>";
                    while ($row = mysql_fetch_array($qs)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['user_name'] . "</option>";
                    } echo "</select>";
                    ?>

                </div>

            </div>
            <div class="form-group">
                <div class="form-label"><label>Comment:</label></div><div class="error" id="comment"></div>
                <div class="form-element">
                    <textarea rows="4" cols="30" name="comment" id="comment"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-element">
                    <input type="submit" name="add" id="btn-send" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include_once'includes/footer.php' ?>
