<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
$error=false;
//Only super admin is allowed to access this page
if ($_SESSION['user_type'] !== 'super') {
    // show permission denied message
    echo 'Permission Denied';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$data_to_store = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    //check whether username or email apc_exists
    $db->where ("user_name",$data_to_store['user_name']);
    $db->where("email", $data_to_store['email']);

      $db->get('users');
      if ($db->count > 0) {
        $error=true;
        $errTyp="danger";
        print_r($db->count);
        $errMSG = "Username already taken! Kindly choose another one";

      }else if ($db->count > 0) {
          $error=true;
          $errTyp="danger";
          print_r($db->count);
            $errMSG = "Email taken! Kindly choose another one";

        }
    //Password should be md5 encrypted
    if(!$error){
      $db = getDbInstance();
    $data_to_store['passwd'] = md5($data_to_store['passwd']);
    $last_id = $db->insert ('users', $data_to_store);
        if($last_id)
    {
    	$_SESSION['success'] = "User added successfully!";
    	header('location: admin_users.php');
    	exit();
    }
  }

}

$edit = false;


require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Add User</h2>
		</div>
	</div>
	<!-- Success message -->
  <?php
  if (isset($errMSG)) {
      ?>
      <div class="form-group">
          <div class="alert alert-dismissible alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
          </div>

      </div>
  <?php } ?>
	<form class="well form-horizontal" action=" " method="post"  id="user_form" enctype="multipart/form-data">
		<?php include_once './forms/admin_users_form.php'; ?>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function(){
   $("#user_form").validate({
       rules: {
            user_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                minlength: 3
            },
        }
    });
});
</script>


<?php include_once 'includes/footer.php'; ?>
