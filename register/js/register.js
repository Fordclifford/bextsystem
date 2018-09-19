 function validateForm() {
        var your_name = $.trim($("#uname").val());
         var church_name = $.trim($("#name").val());
        var your_email = $.trim($("#uemail").val());
        var passwd = $.trim($("#passwd").val());
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
      
        
          if (church_name == "") {
            alert("Enter church name.");
            $("#name").focus();
            return false;
        } else if (!isValidName(church_name)) {
            alert("Enter valid Name!");
            $("#name").focus();
            return false;
        }else if (church_name.length < 3) {
            alert("Name must be atleast 3 character.");
            $("#name").focus();
            return false;
        }

        if (mobl == "") {
            alert("Enter mobile number.");
            $("#mobile").focus();
            return false;
        }else if (!isValidNumber(mobl)) {
            alert("Enter valid Number.");
            $("#mobile").focus();
            return false;
        }else if (mobl.length < 10) {
            alert("Name must be atleast 10 character.");
            $("#mobile").focus();
            return false;
        }


        // validate email
        if (your_email == "") {
            alert("Enter email");
            $("#uemail").focus();
            return false;
        }else
        if (!isValidEmail(your_email)) {
            alert("Enter valid email.");
            $("#uemail").focus();
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

        // validate subject
        if (pass2 == "") {
            alert("Confirm password");
            $("#pass2").focus();
            return false;
        } else if (pass2.length < 6) {
            alert("Password must be atleast 6 character.");
            $("#pass2").focus();
            return false;
        }
        
          if (passwd == "") {
            alert("Enter password");
            $("#passwd").focus();
            return false;
        } else if (passwd.length < 6) {
            alert("Password must be atleast 6 character.");
            $("#passwd").focus();
            return false;
        }


        if (passwd != pass2) {
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
    
$('document').ready(function(){
 var username_state = false;
 var email_state = false;
  var name_state = false;
 $('#uname').on('blur', function(){
  var username = $('#uname').val();
  if (username == '') {
  	username_state = false;
  	return;
  }
  $.ajax({
    url: 'register.php',
    type: 'post',
    data: {
    	'username_check' : 1,
    	'username' : username,
    },
    success: function(response){
      if (response == 'taken' ) {
      	username_state = false;
      	$('#uname').parent().removeClass();
      	$('#uname').parent().addClass("form_error");
      	$('#uname').siblings("span").text('Sorry... Username already taken');
      }else if (response == 'not_taken') {
      	username_state = true;
      	$('#uname').parent().removeClass();
      	$('#uname').parent().addClass("form_success");
      	$('#uname').siblings("span").text('Username available');
      }
    }
  });
 });		
 
  $('#uemail').on('blur', function(){
 	var email = $('#uemail').val();
 	if (email == '') {
 		email_state = false;
 		return;
 	}
 	$.ajax({
      url: 'register.php',
      type: 'post',
      data: {
      	'email_check' : 1,
      	'email' : email,
      },
      success: function(response){
      	if (response == 'taken' ) {
          email_state = false;
          $('#uemail').parent().removeClass();
          $('#uemail').parent().addClass("form_error");
          $('#uemail').siblings("span").text('Sorry... Email already taken');
      	}else if (response == 'not_taken') {
      	  email_state = true;
      	  $('#uemail').parent().removeClass();
      	  $('#uemail').parent().addClass("form_success");
      	  $('#uemail').siblings("span").text('Email available');
      	}
      }
 	});
 });
   $('#name').on('blur', function(){
 	var name = $('#name').val();
 	if (name == '') {
 		name_state = false;
 		return;
 	}
 	$.ajax({
      url: 'register.php',
      type: 'post',
      data: {
      	'name_check' : 1,
      	'name' : name,
      },
      success: function(response){
      	if (response == 'taken' ) {
          name_state = false;
          $('#name').parent().removeClass();
          $('#name').parent().addClass("form_error");
          $('#name').siblings("span").text('Sorry... Seems the church with given name already exist');
      	}else if (response == 'not_taken') {
      	  name_state = true;
      	  $('#name').parent().removeClass();
      	  $('#name').parent().addClass("form_success");
      	  $('#name').siblings("span").text('Church Name available');
      	}
      }
 	});
 });
 
 $('#reg_btn').on('click', function(){
  
    var name = $('#name').val();
    var password = $('#passwd').val();
    var email = $('#uemail').val();
    var mobile = $('#mobile').val();
    var union = $('#union_mission').val();
    var conference = $('#conference').val();
    var username = $('#uname').val();
 	
 	if (username_state == false || email_state == false || name_state == false ) {
	  $('#error_msg').text('Fix the errors in the form first');
	}else{
      // proceed with form submission
      $.ajax({
      	url: 'register.php',
      	type: 'post',
      	data: {
      		'save' : 1,
      		'email' : email,
      		'username' : username,
      		'password' : password,
                'name' : name,
      		'mobile' : mobile,
      		'union' : union,
                'conference' : conference,
      	},
      	success: function(response){
            alert(response);
      		$('#name').val('');
                $('#passwd').val('');
                $('#uemail').val('');
                $('#mobile').val('');
                $('#union_mission').val('');
                $('#conference').val('');
                $('#uname').val('');
                 $('#pass2').val('');
      	}
    
      });
 	}
 });
 
  });