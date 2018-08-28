</div>
<footer id="pagefooter">
    <div id="f-content">

        <div id="foot_notes">
            <p style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p>

        </div>
        <img src="../assets/image/bamboo.png" alt="bamboo" id="footerimg" width="96px" height="125px">
    </div>
</footer>


<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
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
<script src="../assets/js/navigation.js"></script>  

<script type= "text/javascript" src = "../assets/js/conferences.js"></script>
<script language="javascript">print_union("union_mission");</script>
<script src="bootstrap/js/jquery-1.9.0.min.js"></script>


</body>
</html>
<?php
$DB = NULL;
?>