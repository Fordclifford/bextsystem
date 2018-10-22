$(document)
        .ready(function()
        {
            $(function() {
               $("#month").val();
            });
            $('#month_filter').click(function() {               
                 var month = $('#month').val();
                if( month != '')
                {
                $.ajax ({
                url:"ajax/bills/readRecords.php",
                        method:"POST",
                        data:{
                          month:month
                        },                
                success:function(data){                
                    $('.records_content').html(data);
                }
            });
            }
            else
            {
                alert(" Please Select month ");
                }
            }
            );
        });

