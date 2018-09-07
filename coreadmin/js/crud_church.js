$(document).ready(function(){
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


$('#church_data').editable({
container: 'body',
selector: 'td.union',
url: "update_church.php",
title: 'Union',
type: "POST",
dataType: 'json',
source: [{value: '', text: '-Please Select-'},{value: union_arr[1], text: union_arr[1]}, {value:union_arr[0], text: union_arr[0]}],
validate: function(value){
 if($.trim(value) == '')
 {
  return 'This field is required';
 }
   var regex = /^[a-zA-Z ]+$/;
   if(! regex.test(value))
   {
    return 'Enter Valid Name!';
  }
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#church_data').editable({
container: 'body',
selector: 'td.conference',
url: "update_church.php",
title: 'Conference',
type: "POST",
dataType: 'json',
source: [{value: '', text: '-Please Select-'},{value: conference[0], text: conference[0]}, {value: conference[1], text: conference[1]},
{value: conference[2], text: conference[2]},{value: conference[3], text: conference[3]},
{value: conference[4], text: conference[4]},{value: conference[5], text: conference[5]},
{value: conference[6], text: conference[6]},{value: conference[7], text: conference[7]},
{value: conference[8], text: conference[8]},{value: conference[9], text: conference[9]}],
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

$('#church_data').editable({
container: 'body',
selector: 'td.mobile',
url: "update_church.php",
title: 'Mobile',
type: "POST",
dataType: 'json',
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

$('#church_data').editable({
container: 'body',
selector: 'td.user',
url: "update_user.php",
title: 'User',
type: "POST",
dataType: 'json'
});

});
