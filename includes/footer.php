
<!-- /#wrapper -->

<!-- jQuery -->

<div align='center' style="margin: auto">
    <p2 style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Income and Expense Tracker  </p2>


    <!-- Bootstrap Core JavaScript -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="includes/js/metisMenu/metisMenu.min.js"></script>
    <script src="assets/js/tooltip.js" ></script>

    <!-- Custom Theme JavaScript -->
    <script src="includes/js/sb-admin-2.js"></script>

    <script src="includes/js/jquery.validate.min.js"></script>
    <script src="includes/js/angular.js"></script>
    <script src="includes/js/angular-growl.min.js"></script>
    <script src="includes/js/angular-animate.min.js"></script>
    <script src="includes/js/app.js"></script>
    <!-- select2 -->
    <link href="coreadmin/assets/select2/select2.css" rel="stylesheet">
    <script src="coreadmin/assets/select2/select2.js"></script>
    <!-- bootstrap -->

    <link href="coreadmin/assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script src="coreadmin/assets/bootstrap/js/bootstrap.js"></script>

    <!-- bootstrap-datetimepicker -->


    <!-- x-editable (bootstrap) -->
    <link href="coreadmin/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="coreadmin/assets/x-editable/bootstrap-editable/js/bootstrap-editable.js"></script>

    <!-- wysihtml5 -->

    <!-- select2 bootstrap -->
    <link href="coreadmin/assets/select2/select2-bootstrap.css" rel="stylesheet">
    <!-- The End of the Header -->
    <script type="text/javascript">

function myFunction() {
    $.ajax({
        url: "./view_notification.php",
        type: "POST",
        processData: false,
        success: function (data) {
            $("#notification-count").remove();
            $("#notification-latest").show();
            $("#notification-latest").html(data);
        },
        error: function () {}
    });
}

$(document).ready(function () {
    $('body').click(function (e) {
        if (e.target.id != 'notification-icon') {
            $("#notification-latest").hide();
        }
    });
});

    </script>










</body>

</html>
