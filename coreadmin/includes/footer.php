
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
  <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
      <script src="js/jquery.validate.min.js"></script>
  </script>

  <!-- select2 -->
  <link href="assets/select2/select2.css" rel="stylesheet">
  <script src="assets/select2/select2.js"></script>
  <!-- bootstrap -->

  <link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  <script src="assets/bootstrap/js/bootstrap.js"></script>

  <!-- bootstrap-datetimepicker -->


  <!-- x-editable (bootstrap) -->
  <link href="assets/x-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
  <script src="assets/x-editable/bootstrap-editable/js/bootstrap-editable.js"></script>

  <!-- wysihtml5 -->

  <!-- select2 bootstrap -->
  <link href="assets/select2/select2-bootstrap.css" rel="stylesheet">
  <script src="js/crud.js" type="text/javascript" ></script>
  <script>
function myFunction() {
$.ajax({
  url: "view_notification.php",
  type: "POST",
  processData:false,
  success: function(data){
    $("#notification-count").remove();
    $("#notification-latest").show();
	$("#notification-latest").html(data);
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
