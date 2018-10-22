$(document).ready(function(){
$('#church_data').editable({
container: 'body',
selector: 'td.phone',
url: "update_church.php",
title: 'Mobile',
type: "POST",

validate: function(value){
if($.trim(value) == '')
{
 return 'This field is required';
}
var regex = /^[0-9]+$/;
if(! regex.test(value))
{
 return 'Numbers only!';
}
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#church_data').editable({
container: 'body',
selector: 'td.name',
url: "update_church.php",
title: 'Church Name',
type: "POST",
//dataType: 'json',
validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
}
});

 

  $(document).on('click', '.delete_church', function(){
var id = $(this).attr("id");
 if(confirm("Are you sure you want to remove this?"))
{
$.ajax({
 url:"delete_church.php",
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