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
                url:"ajax/balance/readRecords.php",
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



