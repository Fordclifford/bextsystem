<?php
session_start();
require_once './config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail

include_once('includes/header.php');
?>
<body>

        <div id="wrapper">

         <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
     include_once './sidenav.php';
    ?>

<?php endif; ?>

           <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Balance</h1>
        </div>
    </div>

                     <div class="buttoncontainer btn-group">
                    <form class="frm">

                        <div  class="sidebyside btn-group">
                            <label> Year: </label>
                            <?php
                            $c_id = $_SESSION['church'];
                            $f_query = mysql_query("Select id, year from financial_year WHERE church_id = $c_id order by year DESC");

                            echo "<select title=\" Choose Financial Year\" data-toggle=\"tooltip\" style=\" height: 30px;\" class=\" w3-round-large\" name=\"year\" id=\"fyear\" value\"echo $fyear\">";
                            echo "<option value=''> --Select--</option>";
                            while ($row = mysql_fetch_array($f_query)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['year'] . "</option>";
                            } echo "</select>";
                            ?>
                        </div>

                        <div style="padding-top: 20px;"class="sidebyside ">
                            <button  type="button" style="height: 40px;"  name="filter" id="filter" data-toggle="tooltip" title="Click to Search" class="btn btn-info  glyphicon glyphicon-search w3-round-large"> Search </button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">


                        <div class="animate records_content"></div>
                    </div>

                </div>
           </div>

<script src="./assets/js/balance.js"></script>
<?php include_once('includes/footer.php'); ?>
