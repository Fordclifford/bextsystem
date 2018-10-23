$(document).ready(function(){

$('#user_data').editable({
container: 'body',
selector: 'td.user_name',
url: "update_user.php",
title: 'Username',
type: "POST",
//dataType: 'json',
validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
},
success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#user_data').editable({
container: 'body',
selector: 'td.passwd',
url: "update_user.php",
title: 'Update Password',
type: "POST",
validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
},
success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#user_data').editable({
container: 'body',
selector: 'td.user_type',
url: "update_user.php",
title: 'User Type',
type: "POST",
dataType: 'json',
source: [{value: '', text: '-Please Select-'},{value: 'super', text:'Super Admin'}, {value: 'admin', text:'Admin'},
{value: 'auditor', text:'Conference Auditor'},{value: 'treasurer', text:'Church Treasurer'},
{value: 'union_auditor', text:'Union Auditor'}],
validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
},
success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#user_data').editable({
container: 'body',
selector: 'td.status',
url: "update_user.php",
title: 'Status',
type: "POST",
dataType: 'json',
source: [{value: '', text: '-Please Select-'}, {value: 'Approved', text: 'Approved'},{value: 'Pending', text: 'Pending'}],

validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
},
success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#user_data').editable({
container: 'body',
selector: 'td.email',
url: "update_user.php",
title: 'Email',
type: "POST",
dataType: 'json',
validate: function(value){
if($.trim(value) == '')
{
 return 'This field is required';
}
var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(! regex.test(value))
{
 return 'Invalid Email!';
}
}, success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
}
});

$('#user_data').editable({
container: 'body',
selector: 'td.church',
url: "update_church.php",
title: 'Church',
type: "POST",
//dataType: 'json',
validate: function(value){
if($.trim(value) == '')
{
return 'This field is required';
}
},
success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$(document).on('click', '.delete', function(){
var id = $(this).attr("id");
 if(confirm("Are you sure you want to remove this?"))
{
$.ajax({
 url:"delete_user.php",
 method:"POST",
 data:{id:id},
 success:function(data){
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
 }
});
setInterval(function(){
 $('#alert_message').html('');
}, 500);
}
});

});
