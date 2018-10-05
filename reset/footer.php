
    <!-- /#wrapper -->

    <!-- jQuery -->

                    <div align='center' style="margin: auto">
                    <p2 style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p2>


    <!-- Bootstrap Core JavaScript -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../includes/js/metisMenu/metisMenu.min.js"></script>
   
    <script src="../assets/js/tooltip.js" type="text/javascript"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../includes/js/sb-admin-2.js"></script>
          <script src="../includes/js/bootstrap.min.js" type="text/javascript"></script>
           <script src="../includes/js/jquery.validate.min.js"></script>

                          
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
        
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript">
    function validate_forgot() {

           var your_email = $.trim($("#user-email").val());
       
                   // validate name
             // validate email
        if (!isValidEmail(your_email)) {
            alert("Enter valid email.");
            $("#user-email").focus();
            return false;
        }

	if(( (document.getElementById("user-email").value == "")) {
		document.getElementById("validation-message").innerHTML = "Email is required!"
		return false;
	}
	return true;
}
               
               
    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
  
    function isValidName(name) {
        var regex = /^[a-zA-Z ]+$/;
        return regex.test(name);
    }
    
   
</script>
<script>
function validate_password_reset() {
	if((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter new password!"
		return false;
	}
	if(document.getElementById("member_password").value  != document.getElementById("confirm_password").value) {
		document.getElementById("validation-message").innerHTML = "Both password should be same!"
		return false;
	}
	
	return true;
}
</script>

</body>

</html>
<?php
$DB = NULL;
?>