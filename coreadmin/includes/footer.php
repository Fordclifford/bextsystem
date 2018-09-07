
    <!-- /#wrapper -->

    <!-- jQuery -->


    <!-- Bootstrap Core JavaScript -->

<!--        <script src="js/bootstrap.min.js"></script>-->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
  <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
      <script src="js/jquery.validate.min.js"></script>
  </script>

  <!-- select2 -->
  <link href="assets/select2/select2.css" rel="stylesheet">
  <script src="assets/select2/select2.js"></script>

  <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->


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
    <script src="js/crud_church.js" type="text/javascript" ></script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

  <script type="text/javascript">

function myFunction() {
$.ajax({
  url: "view_notification.php",
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
<script type='text/javascript'>
  <?php
    echo "var unions = $jsonUnions; \n";
    echo "var conferences = $jsonConferences; \n";
  ?>
  function loadUnions(){
    var select = document.getElementById("union_mission");
    select.option = new Option('','Select');
    select.onchange = updateConferences;
      for(var i = 0; i < unions.length; i++){
      select.options[i] = new Option(unions[i].val,unions[i].id);
    }
  }
  function updateConferences(){
    var unionSelect = this;
    var unionid = this.value;
    var confSelect = document.getElementById("conference");
    confSelect.options[i] = new Option('','Select');
    confSelect.options.length = 0; //delete all options if any present
    for(var i = 0; i < conferences[unionid].length; i++){
      confSelect.options[i] = new Option(conferences[unionid][i].val,conferences[unionid][i].id);
    }
  }
</script>


</body>

</html>
