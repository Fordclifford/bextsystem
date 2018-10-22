$(document).ready(function() {
	$("#year").change(function() {
		var year_id = $(this).val();
		if(year_id != "") {
			$.ajax({
				url:"get_category.php",
				data:{y_id:year_id},
				type:'POST',
				success:function(response) {
					var resp = $.trim(response);
					$("#category").html(resp);
				}
			});
		} else {
			$("#category").html("<option value=''>------- Select --------</option>");
		}
	});
});
