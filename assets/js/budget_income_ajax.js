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
                url:"ajax/budget/readIncomeRecords.php",
                        method:"POST",
                        data:{
                        year:year
                        },                
                success:function(data){                
                    $('.record_content').html(data);
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

