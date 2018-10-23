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
    $last_id = $db->insert ('church', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Church added successfully!";
    	header('location: churches.php');
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
            <h2 class="page-header">Add churches</h2>
        </div>

</div>
      	<form class="well form-horizontal" action=" "  id="church_form" method="post"  enctype="multipart/form-data">
       <?php  include_once('./forms/church_form.php'); ?>
    </form>
</div>



 <script type='text/javascript'>
      <?php
        echo "var unions = $jsonUnions; \n";
        echo "var conferences = $jsonConferences; \n";
      ?>
      function loadUnions(){
        var select = document.getElementById("union_mission");
        select.option = new Option('','Select');
        select.onchange = updateConferences;
          for(var i = 0; i < unions.length; i++){
          select.options[i] = new Option(unions[i].val,unions[i].id);
        }
      }
      function updateConferences(){
        var unionSelect = this;
        var unionid = this.value;
        var confSelect = document.getElementById("conference");
        confSelect.options[i] = new Option('','Select');
        confSelect.options.length = 0; //delete all options if any present
        for(var i = 0; i < conferences[unionid].length; i++){
          confSelect.options[i] = new Option(conferences[unionid][i].val,conferences[unionid][i].id);
        }
      }
    </script>
    <script type="text/javascript">
$(document).ready(function(){
   $("#church_form").validate({
       rules: {
            name: {
                required: true,
                minlength: 3
            },
            mobile: {
                required: true,
                minlength: 3
            },
        }
    });
});
</script>
<?php include_once 'includes/footer.php'; ?>
