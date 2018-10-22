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
  <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
     include_once './sidenav.php';
    ?>

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
