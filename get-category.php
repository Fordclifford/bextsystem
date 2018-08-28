<?php require_once 'config.php'; ?>
<?php
ob_start();
session_start();
$church_id = $_SESSION['user'];
if(isset($_POST['y_id'])) {
    $sq=mysql_query("select * from `income_sources` where church_id=$church_id AND `financial_year`=".mysql_real_escape_string($_POST['y_id']));
	$sql = "select * from `budget_expenses` where church_id=$church_id AND `financial_year`=".mysql_real_escape_string($_POST['y_id']);
	$res = mysql_query( $sql);
	if(mysql_num_rows($res) > 0) {
		echo "<option value=''>------- Select --------</option>";
		while($row = mysql_fetch_object($res)) {
			echo "<option value='".$row->sid."'>".$row->expense_name."</option>";
		}
	}
        else{
          ?>
    <script>
        alert('No Expense Records for that year!\n You need to add ...');        
    </script>
    <?php   
        }
        if(mysql_num_rows($sq) == 0) {
            ?>
    ?>
    <script>
        alert(' No income found for that year \n You need to add income for your church\n You will be redirected to income page ...');
        window.location.href = 'income.php';
    </script>
    <?php    
        }
} else {
	header('location: ./');
}
?>
<?php ob_end_flush(); ?>