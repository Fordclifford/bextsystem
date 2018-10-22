
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

   
$('document').ready(function () {   
   
  var input_state = false;
     $('#mobile').on('blur', function () {
          var mobl = $.trim($('#mobile').val());
          regex = /^[0-9]+$/;
    if (mobl == "") {
        $('#mobile').parent().removeClass();
        $('#mobile').parent().addClass("form_error");
        $('#mobile').siblings("span").text('Cannot be Empty!');
        input_state = false;
        return ;
        
    }  else if (!regex.test(mobl)) {
        $('#mobile').parent().removeClass();
        $('#mobile').parent().addClass("form_error");
        $('#mobile').siblings("span").text('Enter valid Number.');
        input_state = false;
       return ;
       
        
    } else if ($.trim($("#mobile").val()).length < 10) {
        $('#mobile').parent().removeClass();
        $('#mobile').parent().addClass("form_error");
        $('#mobile').siblings("span").text('Number must be atleast 10 character.');
        input_state = false;
        return ;  
        
    } else{
         $('#mobile').parent().removeClass();
           $('#mobile').parent().addClass("form_success");
         $('#mobile').siblings("span").text('Looks Good');
         input_state = true;
        return;
    }
     });
    
      
      $('#pass2').on('blur', function () {
       var pass2 = $.trim($("#pass2").val());
       var passwd = $.trim($("#passwd").val());
    if (pass2 == '') {
       
         $('#pass2').parent().removeClass();
        $('#pass2').parent().addClass("form_error");
        $('#pass2').siblings("span").text('Confirm password');
         $("#pass2").focus();
       input_state = false;
        return ; 
    } else if (pass2.length < 6) {
         $('#pass2').parent().removeClass();
        $('#pass2').parent().addClass("form_error");
        $('#pass2').siblings("span").text('Password must be atleast 6 character.');
         $("#pass2").focus();
         input_state = false;
        return ; 
    }
        
    else if (passwd != pass2) {
      
        $('#passwd').parent().removeClass();
        $('#passwd').parent().addClass("form_error");
        $('#passwd').siblings("span").text("Passwords do not match!.");
        $('#pass2').parent().addClass("form_error");
        $('#pass2').siblings("span").text('Passwords do not match!');
        $("#pass2").focus();
         input_state = false;
        return ; 
    }else{
         $('#passwd').parent().removeClass();
          $('#pass2').parent().removeClass();
           $('#passwd').parent().addClass("form_success");
           $('#pass2').parent().addClass("form_success");
         $('#passwd').siblings("span").text('Looks Good');
         $('#pass2').siblings("span").text('Looks Good');
        input_state = true;
        return ;
    }
    });
     $('#passwd').on('blur', function () {
     var passwd = $.trim($("#passwd").val());
     
    if (passwd == '') {
         $('#passwd').parent().removeClass();
        $('#passwd').parent().addClass("form_error");
        $('#passwd').siblings("span").text('Enter password');
       input_state=false;
        return ;
    } else if (passwd.length < 6) {    
         $('#passwd').parent().removeClass();
        $('#passwd').parent().addClass("form_error");
        $('#passwd').siblings("span").text('Password must be atleast 6 character.');
       input_state=false;
        return;
    }
    if (passwd!=''){
        $('#passwd').parent().removeClass();         
           $('#passwd').parent().addClass("form_success");           
         $('#passwd').siblings("span").text('Looks Good');
            input_state = true;
            return;
    }
    if(passwd.length > 6){
          $('#passwd').parent().removeClass();         
          $('#passwd').parent().addClass("form_success");           
         $('#passwd').siblings("span").text('Looks Good');
         input_state = true;
            return;
    }

     });
     
     
    $('#uname').on('blur', function () {
        var username = $('#uname').val();
        if (username == '') {
        $('#uname').parent().removeClass();
        $('#uname').parent().addClass("form_error");
        $('#uname').siblings("span").text('Enter name!');
        $("#uname").focus();
            input_state = false;
            return;
        }
       if (!isValidName(username)) {
      
         $('#uname').parent().removeClass();
        $('#uname').parent().addClass("form_error");
        $('#uname').siblings("span").text('Enter valid name!');
        $("#uname").focus();
        input_state = false;
            return;
    } else if (username.length < 3) {
         $('#uname').parent().removeClass();
        $('#uname').parent().addClass("form_error");
        $('#uname').siblings("span").text('Name must be atleast 3 character!');
        $("#uname").focus();
       input_state = false;
            return;
    }
        $.ajax({
            url: 'register.php',
            type: 'post',
            data: {
                'username_check': 1,
                'username': username,
            },
            success: function (response) {
                if (response == 'taken') {
                    input_state = false;
                    $('#uname').parent().removeClass();
                    $('#uname').parent().addClass("form_error");
                    $('#uname').siblings("span").text('Sorry... Username already taken');
                } else if (response == 'not_taken') {
                    input_state = true;
                    $('#uname').parent().removeClass();
                    $('#uname').parent().addClass("form_success");
                    $('#uname').siblings("span").text('Username available');
                }
            }
        });
    });

    $('#uemail').on('blur', function () {
        var email = $('#uemail').val();
        if (email == '') {
            $('#uemail').parent().removeClass();
             $('#uemail').parent().addClass("form_error");
             $('#uemail').siblings("span").text('Cannot be empty!');
            input_state = false;
            return;
        }
         if (!isValidEmail(email)) {
        $('#uemail').parent().removeClass();
        $('#uemail').parent().addClass("form_error");
        $('#uemail').siblings("span").text('Enter valid email.');
        input_state = false;
            return;
    }
        $.ajax({
            url: 'register.php',
            type: 'post',
            data: {
                'email_check': 1,
                'email': email,
            },
            success: function (response) {
                if (response == 'taken') {
                    input_state = false;
                    $('#uemail').parent().removeClass();
                    $('#uemail').parent().addClass("form_error");
                    $('#uemail').siblings("span").text('Sorry... Email already taken');
                } else if (response == 'not_taken') {
                    input_state = true;
                    $('#uemail').parent().removeClass();
                    $('#uemail').parent().addClass("form_success");
                    $('#uemail').siblings("span").text('Email available');
                }
            }
        });
    });
    $('#name').on('blur', function () {
        var name = $('#name').val();
          
        if (name == "") {
    
        $('#name').parent().removeClass();
        $('#name').parent().addClass("form_error");
        $('#name').siblings("span").text('Cannot be Empty!');
        $("#name").focus();
         input_state = false;
            return;
    } else if (!isValidName(name)) {
         $('#name').parent().removeClass();
        $('#name').parent().addClass("form_error");
        $('#name').siblings("span").text('Enter valid Name!');
       
         input_state = false;
            return;
    } else if (name.length < 3) {
        $('#name').parent().removeClass();
        $('#name').parent().addClass("form_error");
        $('#name').siblings("span").text('Name must be atleast 3 characters.');
       
        input_state = false;
            return;
    }
        $.ajax({
            url: 'register.php',
            type: 'post',
            data: {
                'name_check': 1,
                'name': name,
            },
            success: function (response) {
                if (response == 'taken') {
                    input_state = false;
                    $('#name').parent().removeClass();
                    $('#name').parent().addClass("form_error");
                    $('#name').siblings("span").text('Sorry... Seems the church with given name already exist');
                } else if (response == 'not_taken') {
                    input_state = true;
                    $('#name').parent().removeClass();
                    $('#name').parent().addClass("form_success");
                    $('#name').siblings("span").text('Church Name available');
                }
            }
        });
    });
    
    $('#conference').on('blur', function () {
          var conf = $.trim($("#conference").val());
       if (conf == '') {    
        $('#conference').parent().removeClass();
        $('#conference').parent().addClass("form_error");
        $('#conference').siblings("span").text('Cannot be Empty!');
         input_state = false;
            return;
    } if(conf != ''){  
         $('#conference').parent().removeClass();
         $('#conference').parent().addClass("form_success");
         $('#conference').siblings("span").text('Looks Good');
        input_state = true;
            return;
    }
 
    });
 
    
   $('#union_mission').on('click', function () { 
     var union = $.trim($("#union_mission").val());
    if (union == '') {    
      
        $("#union_mission").focus();
        $('#union_mission').parent().removeClass();
        $('#union_mission').parent().addClass("form_error");
        $('#union_mission').siblings("span").text('Cannot be Empty!');
         input_state = false;
            return;
    } if(union != ''){     
        $('#union_mission').parent().removeClass();
        $('#union_mission').parent().addClass("form_success");
         $('#union_mission').siblings("span").text('Looks Good');
          input_state = true;
            return;
    }
  });
  $('#reg_btn').on('click', function () {
  if (input_state == false) {
      $('#error_msg').text('Fix the errors in the form first');
        }
        if (input_state == true) {
        var name = $('#name').val();
        var password = $('#passwd').val();
        var email = $('#uemail').val();
        var mobile = $('#mobile').val();
        var union = $('#union_mission').val();
        var conference = $('#conference').val();
        var username = $('#uname').val();    

       
            // proceed with form submission
            $.ajax({
                url: 'register.php',
                type: 'post',

                data: {
                    'save': 1,
                    'email': email,
                    'username': username,
                    'password': password,
                    'name': name,
                    'mobile': mobile,
                    'union': union,
                    'conference': conference,
                },
                beforeSend: function () {
                    $('.loader').show();
                },                
                success: function (response) {
                    $('.loader').hide();
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

 

    
       

