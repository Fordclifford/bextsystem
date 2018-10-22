<?php
session_start();
require_once './coreadmin/config/config.php';
//If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    
}

//If user has previously selected "remember me option", his credentials are stored in cookies.
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    //Get user credentials from cookies.
    $username = filter_var($_COOKIE['username']);
    $passwd = filter_var($_COOKIE['password']);
    $db->where("user_name", $username);
    $db->where("passwd", $passwd);
    $row = $db->get('users');

    if ($db->count >= 1) {
        //Allow user to login.
        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['user_type'] = $row[0]['user_type'];
        header('Location:index.php');
        exit;
    } else { //Username Or password might be changed. Unset cookie
        unset($_COOKIE['username']);
        unset($_COOKIE['password']);
        setcookie('username', null, -1, '/');
        setcookie('password', null, -1, '/');
        header('Location:login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>B&E System</title>

        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
         <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
         <link rel="stylesheet" href="coreadmin/css/style.css" type="text/css"/>


        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css"/>
		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    

        <!-- MetisMenu CSS -->
        <link href="includes/js/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css"/>
        <!-- Custom CSS -->

        <link href="includes/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="includes/js/jquery.min.js" type="text/javascript"></script>


    </head>
    <body>
       
      <div class="container-fluid">
   <div class="row">
       <img height="200px" width="1500px" src="assets/image/header3.png"  border="0" alt="Main Banner">
   </div>
</div>
       


            <div id="wrapper">


<div >
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Please Login</h1>
        </div>
    </div>

    <div class="row">
        <div class=" col-md-1">
        </div>
        <div class="well col-md-3">
            <form id="login" method="POST" action="authenticate.php">
                <div class="form-group">
                    <label class="col-md-4 control-label">Login as:</label>
                    <div class="col-md-4">
                        <div class="radio">
                            <label>

                                <input type="radio" name="user_type" value="treasurer" required=""/> Church Treasurer
                            </label>
                        </div>
                        <div class="radio">
                            <label>

                                <input type="radio" name="user_type" value="auditor" required="" /> Auditor
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="user_type" value="admin" required="" /> Admin
                            </label>
                        </div>

                    </div>
                </div>
             </div>
        <div class="col-md-4">
            <div id="login" style="position:relative;" >
                <div style="background: #B6E0FF;" class="panel panel-default">
                    <div class="panel-heading">Please Enter Login Details</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">username</label>
                            <input type="text" style="height:30px" name="username" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label class="control-label">password</label>
                            <input type="password" style="height:30px" name="passwd" class="form-control" required="required">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="1">Remember Me
                            </label>
                        </div>
                          <div style="margin: 5px">
                                <a  style="color: #0000CC;" href="register/" data-toggle="tooltip" title="click to register"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a>
                                <div align='right' >  <span>Forgot <a title="click to reset password" data-toggle="tooltip" style="color: #0000CC" href="reset/"> password?</a></span></div>
                            </div>
<?php if (isset($_SESSION['login_failure'])) { ?>
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $_SESSION['login_failure'];
                            unset($_SESSION['login_failure']); ?>
                            </div>
                            <?php } ?>
                        <button type="submit" class="btn btn-success loginField" >Login</button>
                    </div>
                </div>
            </div>
        </div>
         </form>
        <div class=" col-md-4">
        </div>


    </div>
    <div style="margin:20px"class="clearfix"></div>
    <!--  -->
</div>

<?php include_once"includes/footer.php"; ?>
