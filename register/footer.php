
    <!-- /#wrapper -->

    <!-- jQuery -->

           <div align='center' style="margin: auto">
                    <p2 style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p2>

 <script src="../includes/js/bootstrap.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../includes/js/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../includes/js/sb-admin-2.js"></script>
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
     <script src="../assets/js/tooltip.js" > </script>
<script src="../assets/js/tooltip.js" > </script>
     <script>
     $(document).ready(function () {
         $('[data-toggle="tooltip"]').tooltip();
          });
        </script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript">
    function validateForm() {

        var your_name = $.trim($("#uname").val());
        var your_email = $.trim($("#uemail").val());
        var pass1 = $.trim($("#pass1").val());
        var pass2 = $.trim($("#pass2").val());
        var conf = $.trim($("#conference").val());
        var mobl = $.trim($("#mobile").val());
        var union = $.trim($("#union_mission").val());

        if (union == "") {
            alert("Please select union");
            $("#union_mission").focus();
            return false;
        }

        if (conf == "") {
            alert("Select your conference.");
            $("#conference").focus();
            return false;
        }

        // validate name
        if (your_name == "") {
            alert("Enter your name.");
            $("#uname").focus();
            return false;
        } else if (!isValidName(your_name)) {
            alert("Enter valid Name!");
            $("#uname").focus();
            return false;
        }else if (your_name.length < 3) {
            alert("Name must be atleast 3 character.");
            $("#uname").focus();
            return false;
        }


        if (!isValidNumber(mobl)) {
            alert("Enter valid Number.");
            $("#mobile").focus();
            return false;
        }else if (mobl.length < 10) {
            alert("Name must be atleast 10 character.");
            $("#mobile").focus();
            return false;
        }


        // validate email
        if (!isValidEmail(your_email)) {
            alert("Enter valid email.");
            $("#uemail").focus();
            return false;
        }

        // validate subject
        if (pass1 == "") {
            alert("Enter password");
            $("#pass1").focus();
            return false;
        } else if (pass1.length < 6) {
            alert("Password must be atleast 6 character.");
            $("#pass1").focus();
            return false;
        }

        if (pass1 != pass2) {
            alert("Password does not matched.");
            $("#pass2").focus();
            return false;
        }

        return true;
    }
    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    function isValidNumber(mobl) {
        var regex = /^[0-9]+$/;
        return regex.test(mobl);

    }
    function isValidName(name) {
        var regex = /^[a-zA-Z ]+$/;
        return regex.test(name);
    }
</script>


</body>
</html>
<?php
$DB = NULL;
?>
