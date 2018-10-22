<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bext_system");
if (!empty($_POST['add'])) {
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $sender = $_SESSION['user_logged_in'];
    $recipient = mysqli_real_escape_string($conn, $_POST["recipient"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $sql = "INSERT INTO comments (subject,comment,sender,recipient) VALUES('" . $subject . "','" . $comment . "','" . $sender . "','" . $recipient . "')";
    mysqli_query($conn, $sql);
}
include_once '../config.php';
include_once'includes/header.php'
?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Notifications</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
                <a href="add_notification.php">
                    <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
                </a>
            </div>
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
                    
                      $sqls = "Select * FROM users  ";
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