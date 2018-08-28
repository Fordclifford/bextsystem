// Add Record
function addRecord() {
    // get values
    var source = $("#source").val();
    var amount = $("#amount").val();
    var year = $("#year").val();
   

    // Add record
    $.post("ajax/income/addRecord.php", {
        source: source,
        amount: amount,
         year:year
       
       
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        window.location.reload();

        // clear fields from the popup
        $("#source").val("");
        $("#amount").val("");
        $("#year").val("");
        
       
    });
}

// READ records
function readRecords() {
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
                url:"ajax/income/filter_income.php",
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


}


function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete Income?");
    if (conf == true) {
        $.post("ajax/income/deleteUser.php", {
                id: id
            },
            function (data, status) {
                // reload Income by using readRecords();
               window.location.reload();
            }
        );
    }
}

function GetIncomeDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/income/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var income = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_source").val(income.source_name);
            $("#update_amount").val(income.amount);
            $("#year").val(income.financial_year);
                    }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var source = $("#update_source").val();
    var amount = $("#update_amount").val();
     var year = $("#update_year").val();
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/income/updateUserDetails.php", {
            id: id,
            source: source,
            amount: amount,
            year: year
          
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Income by using readRecords();
            window.location.reload();
            readRecords();
        }
    );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});