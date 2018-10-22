<?php 
ob_start();
session_start();
require_once 'config.php'; 
echo $church_id = $_SESSION['church'];
if(isset($_POST['y_id'])) {
    $yr =$_POST['y_id'];

    $sq=mysql_query("select * from `income_sources` where church_id=$church_id AND financial_year=".mysql_real_escape_string($_POST['y_id']));
	$sql = "select * from actual_income where church_id='$church_id' AND financial_year_id='$yr'";
	$res = mysql_query( $sql);
	if(mysql_num_rows($res) > 0) {
		echo "<option value=''>------- Select --------</option>";
		while($row = mysql_fetch_object($res)) {
			echo "<option value='".$row->id."'>".$row->source_name."</option>";
		}
	}
        else{
          ?>
    <script>
        alert('No Income Records for that year!\n You need to add ...');
    </script>
    <?php
        }
}     
?>
<?php ob_end_flush(); ?>