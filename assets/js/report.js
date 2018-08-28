$(document)
        .ready(function()
        {
            $(function() {
                $("#fyear").val();
            });
            $('#filter').click(function() {               
                 var year = $('#fyear').val();
                if(year != '')
                {
                $.ajax ({
                url:"i_e_report.php",
                        method:"POST",
                        data:{
                        year:year
                        },                
                success:function(data){                
                    $('.records_content').html(data);
                }
            });
            }
            else
            {
                alert(" Please Select Year ");
                }
            }
            );
        });

