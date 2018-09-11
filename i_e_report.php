<?php
require_once 'chartdb.php';
ob_start();
session_start();
// include Database connection file
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <script src="assets/zingchart/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "assets/zingchart/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
    </head>
    <body>
  


       <div class="row">
           <div class="col-lg-12">
       <div id='myChart'></div>
           </div>
       </div>
         </body>
 <script>
<?php
$data = mysqli_query($mysqli, "SELECT MONTHNAME(date),amount FROM bill");
$data1 = mysqli_query($mysqli, "SELECT MONTHNAME(date),amount FROM bill");
?>

            var myData = [<?php
while ($info = mysqli_fetch_array($data))
    echo $info['amount'] . ','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
?>];
            var myLabels = [<?php
while ($info = mysqli_fetch_array($data))
    echo '"' . $info['MONTHNAME(date)'] . '",'; /* The concatenation operator '.' is used here to create string values from our database names. */
?>];
        </script>

        <script>

        var myConfig = {
            type: "bar",
            plotarea: {
                adjustLayout: true
            },
            scaleX: {
                label: {
                    text: "Here is a category scale"
                },
                labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug"]
            },
            series: [
                 {
                    values: function(){return myData;}
                },
                {
                    values: [20, 40, 25, 50, 15, 45, 33, 34]
                },
                {
                    values: [5, 30, 21, 18, 59, 50, 28, 33]
                }
            ]
        };

        zingchart.render({
            id: 'myChart',
            data: myConfig,
            height: "100%",
            width: "100%"
        });

</script>
                <div class="clearfix"></div>



            </section>
        </div>
        <footer id="pagefooter">
            <div id="f-content">

                <div id="foot_notes">
                    <p style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p>

                </div>
                <img src="assets/image/bamboo.png" alt="bamboo" id="footerimg" width="96px" height="125px">
            </div>
        </footer>

        <script src="assets/jquery-1.11.3-jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/navigation.js"></script>
        <script>
                        $(document).ready(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
    </script>
<!--    <script src="assets/js/report.js"></script>-->



   

</html>
<?php ob_end_flush(); ?>
