<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to churches.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);

    //Insert timestamp
    $db = getDbInstance();
    $last_id = $db->insert ('union_mission', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Union/Mission added successfully!";
    	header('location: unions.php');
    	exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Union</h2>
        </div>

</div>
  	<form class="well form-horizontal" action=" " method="post"  id="union_form" enctype="multipart/form-data">
       <?php  include_once('./forms/union_form.php'); ?>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#union_form").validate({
       rules: {
            union_name: {
                required: true,
                minlength: 3
            }
                  }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>
