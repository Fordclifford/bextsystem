// Add Record
function addRecord() {
    // get values
    var expense = $("#expense").val();
    var amount = $("#amount").val();
    var year = $("#year").val();
   

    // Add record
    $.post("ajax/expense/addRecord.php", {
        expense: expense,
        amount: amount,
        year:year
        
       
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
       window.location.reload();

        // clear fields from the popup
        $("#expense").val("");
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
                url:"ajax/expense/filter_expenses.php",
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


function DeleteExpense(id) {
    var conf = confirm("Are you sure, do you really want to delete expense?");
    if (conf == true) {
        $.post("ajax/expense/deleteRecord.php", {
                id: id
            },
            function (data, status) {
                // reload Income by using readRecords();
               window.location.reload();
            }
        );
    }
}

function GetExpenseDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/expense/readExpenseDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var expense = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_expense").val(expense.expense_name);
            $("#update_amount").val(expense.amount);
            $("#year").val(expense.financial_year);
                    }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateExpenseDetails() {
    // get values
    var expense = $("#update_expense").val();
    var amount = $("#update_amount").val();
     var year = $("#update_year").val();
    
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/expense/updateExpenseDetails.php", {
            id: id,
            expense: expense,
            amount: amount,
            year: year
          
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Income by using readRecords();
           window.location.reload();
        }
    );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});