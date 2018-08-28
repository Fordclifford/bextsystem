$(document)
        .ready(function()
        {
            $(function() {
               $("#year").val();
            });
            $('#filter').click(function() {               
                 var year = $('#year').val();
                if( year != '')
                {
                $.ajax ({
                url:"ajax/bills/filter.php",
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

