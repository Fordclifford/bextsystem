
    <!-- /#wrapper -->

    <!-- jQuery -->
</body>
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
<script src="js/register.js" type="text/javascript"></script>

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
                        


</html>
<?php
$DB = NULL;
?>
