// Add Record
function addActualIncome() {
// get values
    var source = $("#source").val();
    var amount = $("#amount").val();
    var year = $("#financial_year_id").val();
    $.ajax({
        url: "ajax/income/addActualIncome.php",
        method: "POST",
        data: {source_name: source, amount: amount, financial_year_id: year},
        success: function (data) {
           
           $("#add_new_record_modal").modal("hide");
            $("#source").val("");
            $("#amount").val("");
            $("#financial_year_id").val("");
            window.location.reload();

        }
    });
    
}

function addEstimatedIncome() {
    
// get values
    var source = $("#source").val();
    var amount = $("#amount").val();
    var year = $("#financial_year_id").val();
    $.ajax({
        url: "ajax/income/addEstimatedIncome.php",
        method: "POST",
        data: {source_name: source, amount: amount, financial_year: year},
        success: function (data) {
            
            $("#add_new_record_modal").modal("hide");
            $("#source").val("");
            $("#amount").val("");
            $("#financial_year_id").val("");
            window.location.reload();

        }
    });
    
}

function addExpense() {
// get values
    var name = $("#expense_name").val();
    var amount = $("#amount").val();
    var year = $("#financial_year").val();
    $.ajax({
        url: "ajax/expense/addExpense.php",
        method: "POST",
        data: {expense_name: name, amount: amount, financial_year: year},
        success: function (data) {
            $("#add_new_record_modal").modal("hide");
            $("#source").val("");
            $("#amount").val("");
            $("#financial_year_id").val("");
            window.location.reload();

        }
    });
    
}
