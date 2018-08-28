</div>
<footer id="pagefooter">
    <div id="f-content">

        <div id="foot_notes">
            <p style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p>

        </div>
        <img src="../assets/image/bamboo.png" alt="bamboo" id="footerimg" width="96px" height="125px">
    </div>
</footer>

</body>
</html>
<?php
$DB = NULL;
?>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
    function validate_forgot() {

        var your_name = $.trim($("#user-login-name").val());
        var your_email = $.trim($("#user-email").val());
       
                   // validate name
        if (your_name == "") {
            alert("Enter your name.");
            $("#user-login-name").focus();
            return false;
        } else if (!isValidName(your_name)) {
            alert("Enter valid Name!");
            $("#user-login-name").focus();
            return false;
        }else if (your_name.length < 3) {
            alert("Name must be atleast 3 character.");
            $("#user-login-name").focus();
            return false;
        }
        

             // validate email
        if (!isValidEmail(your_email)) {
            alert("Enter valid email.");
            $("#user-email").focus();
            return false;
        }

	if((document.getElementById("user-login-name").value == "") && (document.getElementById("user-email").value == "")) {
		document.getElementById("validation-message").innerHTML = "Login name or Email is required!"
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


