
    <!-- /#wrapper -->

    <!-- jQuery -->

                    <div align='center' style="margin: auto">
                    <p2 style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p2>


    <!-- Bootstrap Core JavaScript -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="includes/js/metisMenu/metisMenu.min.js"></script>
    <script src="assets/js/tooltip.js" > </script>

    <!-- Custom Theme JavaScript -->
    <script src="includes/js/sb-admin-2.js"></script>
        <script src="includes/js/bootstrap.min.js"></script>
           <script src="includes/js/jquery.validate.min.js"></script>


           <!-- The End of the Header -->
			<script type="text/javascript">

	function myFunction() {
		$.ajax({
			url: "./view_notification.php",
			type: "POST",
			processData:false,
			success: function(data){
				$("#notification-count").remove();
				$("#notification-latest").show();$("#notification-latest").html(data);
			},
			error: function(){}
		});
	 }

	 $(document).ready(function() {
		$('body').click(function(e){
			if ( e.target.id != 'notification-icon'){
				$("#notification-latest").hide();
			}
		});
	});

	</script>
         <script>
                                        $(document).ready(function () {
                                            $('[data-toggle="tooltip"]').tooltip();
                                        });
        </script>




</body>

</html>
